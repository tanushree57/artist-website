<?php

namespace GFExcel\Repository;

use GFExcel\GFExcel;
use GFExcel\GFExcelAdmin;
use GFExport;
use GF_Field;

class FieldsRepository
{
    private $fields = [];

    private $form;

	/**
	 * @since 1.9
	 * @var array GF Feed object.
	 */
    private $feed;

    private $meta_fields = [];

    const KEY_DISABLED_FIELDS = 'gfexcel_disabled_fields';

    const KEY_ENABLED_FIELDS = 'gfexcel_enabled_fields';

    /**
     * @var GFExcelAdmin
     */
    private $admin;

    public function __construct(array $form, array $feed = [])
    {
        $this->form = $form;
        $this->feed = $feed;
        $this->admin = GFExcelAdmin::get_instance();
    }

    /**
     * Get the fields to show in the excel. Fields can be disabled using the hook.
     * @param bool $unfiltered Whether to return all fields, including the disabled ones.
     * @return GF_Field[] The fields.
     */
    public function getFields($unfiltered = false)
    {
        if (empty($this->fields) || $unfiltered) {
            $this->fields = $this->form['fields'];
            $this->addNotesField();

            if ($this->useMetaData()) {
                $fields_map = ['first' => [], 'last' => []];
                foreach ($this->meta_fields as $key => $field) {
                    $fields_map[in_array($key, $this->getFirstMetaFields(), false) ? 'first' : 'last'][] = $field;
                }
                $this->fields = array_merge($fields_map['first'], $this->fields, $fields_map['last']);
            }

            // remove display only fields like `html`, `section`
            $this->fields = array_filter($this->fields, static function(\GF_Field  $field): bool {
                return !($field->displayOnly ?? false);
            });

            if ($unfiltered) {
                $fields = $this->fields;
                $this->fields = []; //reset

                return $fields;
            }

            $this->filterDisabledFields();
            $this->fields = $this->sortFields();
        }

        return $this->fields;
    }

    /**
     * Check if we want meta data, if so, add those fields and format them.
     * @return boolean
     */
    private function useMetaData(): bool
    {
        $use_metadata = (bool) gf_apply_filters(
            [
                "gfexcel_output_meta_info",
                $this->form['id'],
            ],
            true
        );

        if (!$use_metadata) {
            return false;
        }

        if (empty($this->meta_fields)) {
            $form = GFExport::add_default_export_fields(['id' => $this->form['id'], 'fields' => []]);
            $this->meta_fields = array_reduce($form['fields'], function ($carry, GF_Field $field) {
                $field->type = 'meta';
                $carry[$field->id] = $field;

                return $carry;
            });
        }

        return $use_metadata;
    }

    /**
     * Get the id's of the meta fields we want before the rest of the fields
     * @return string[] The meta field id's.
     */
    private function getFirstMetaFields(): array
    {
        return ['id', 'date_created', 'ip'];
    }

    /**
     * Add a notes field to the export.
     * This isn't a normal field, that's why we add it our self
     *
     * @return array
     */
    private function addNotesField()
    {
        $repository = new FormsRepository($this->form['id']);
        if ($repository->showNotes()) {
            $this->fields = array_merge($this->fields, [
                new GF_Field([
                    'formId' => $this->form['id'],
                    'type' => 'notes',
                    'id' => 'notes',
                    'label' => esc_html__('Notes', 'gravityforms'),
                ])
            ]);
        }

        return $this->fields;
    }

    /**
     * Removes fields in disabled_fields array, or fields that are disabled by the hook
     * @return array
     */
    private function filterDisabledFields()
    {
        $disabled_fields = $this->getDisabledFields();
        $this->fields = array_filter($this->fields, static function (GF_Field $field) use ($disabled_fields) {
            return !gf_apply_filters([
                'gfexcel_field_disable',
                $field->get_input_type(),
                $field->formId,
                $field->id,
            ], in_array($field->id, $disabled_fields, false), $field);
        });

        return $this->fields;
    }

    /**
     * Retrieve the disabled field id's in array
     * @return array
     */
    public function getDisabledFields()
    {
        $result = [];

        if (($settings = $this->admin->get_plugin_settings()) && is_array($settings)) {
            foreach ($settings as $key => $value) {
                if (strpos($key, 'enabled_metafield_') === 0 && $value == 0) {
                    $result[] = str_replace('enabled_metafield_', '', $key);
                }
            }
        }

        if (array_key_exists(static::KEY_DISABLED_FIELDS, $this->form)) {
            $result = explode(',', $this->form[static::KEY_DISABLED_FIELDS]);
        }

	    $form_id = rgar( $this->form, 'id' );
	    $feed_id = rgar( $this->feed, 'id' );

	    return gf_apply_filters( [
		    'gfexcel_disabled_fields',
		    rgar( $this->form, 'id' ),
		    rgar( $this->feed, 'id' )
	    ], $result, $form_id, $feed_id );
    }

    /**
     * Return sorted array of the keys of enabled fields
     * @return string[] The enabled fields.
     */
    public function getEnabledFields()
    {
        $result = [];
        if (array_key_exists(static::KEY_ENABLED_FIELDS, $this->form)) {
            $result = explode(',', $this->form[static::KEY_ENABLED_FIELDS]);
        }

        $form_id = rgar( $this->form, 'id' );
        $feed_id = rgar( $this->feed, 'id' );

	    return gf_apply_filters( [
		    'gfexcel_enabled_fields',
		    rgar( $this->form, 'id' ),
		    rgar( $this->feed, 'id' )
	    ], $result, $form_id, $feed_id );
    }

    /**
     * Sort fields according to sorted keys
     * @param GF_Field[] $fields The unsorted fields.
     * @return GF_Field[] The sorted fields.
     */
    public function sortFields($fields = [])
    {
        if (empty($fields)) {
            $fields = $this->fields;
        }

        $sorted_keys = $this->getEnabledFields();
        $fields = array_reduce($fields, static function (array $carry, GF_Field $field): array {
            $carry[$field->id] = $field;

            return $carry;
        }, []);

        // sort fields, and remove any values that aren't field (objects).
        $fields = @array_values(array_filter(array_replace(array_flip($sorted_keys), $fields), 'is_object'));

        return $fields;
    }

    /**
     * Returns the sort field options for a form.
     * @since 1.9.0
     * @param mixed[]|null $form The form object.
     * @return string[][] The sort field options.
     */
    public function getSortFieldOptions(?array $form = null): array
    {
        $form = $form ?? $this->form;

        return array_reduce($form['fields'] ?? [], static function (array $fields, \GF_Field $field): array {
            // Fields that have no subfields can be added as they are.
            if (!$field->get_entry_inputs()) {
                $fields[] = [
                    'value' => $field->id,
                    'label' => $field->label,
                ];

                return $fields;
            }

            // Field has subfields. Lets try to add those.
            foreach ($field->get_entry_inputs() as $sub_field) {
                // Hidden fields are probably not filled out, so don't show them.
                if ($sub_field['isHidden'] ?? false) {
                    continue;
                }

                $fields[] = [
                    'value' => $sub_field['id'],
                    'label' => sprintf('%s (%s)', $sub_field['label'], $field->label),
                ];
            }

            return $fields;
        }, [
            // Add `date of entry` as first item.
            [
                'value' => 'date_created',
                'label' => __('Date of entry', GFExcel::$slug),
            ]
        ]);
    }
}
