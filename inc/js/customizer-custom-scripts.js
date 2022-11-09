( function( api ) {

	// Extends our custom "eventsia" section.
	api.sectionConstructor['eventsia'] = api.Section.extend( {

		// No eventsias for this type of section.
		attachEventsias: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
