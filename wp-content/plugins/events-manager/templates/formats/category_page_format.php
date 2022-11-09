<section class="em-item-header" style="--default-border:#_CATEGORYCOLOR;">
	{has_image}
	<div class="em-item-image">
		#_CATEGORYIMAGE{medium}
	</div>
	{/has_image}
	<div class="em-item-meta">
		<section class="em-item-meta-column">
			<section class="em-location-next-event">
				<h3><?php esc_html_e('Next Event', 'events-manager'); ?></h3>
				{has_events}
				<div class="em-item-meta-line em-taxonomy-events em-category-events">
					<span class="em-icon-calendar em-icon"></span>
					<div>
						<p>#_CATEGORYNEXTEVENT</p>
						<p><a href="#upcoming-events"><?php esc_html_e('See All', 'events-manager'); ?></a></p>
					</div>
				</div>
				{/has_events}
				{no_events}
				<div class="em-item-meta-line em-taxonomy-no-events em-category-no-events">
					<span class="em-icon-calendar em-icon"></span>
					<div><?php esc_html_e('No upcoming events', 'events-manager'); ?></p></div>
				</div>
				{/no_events}
			</section>
			{no_loc_image}
		</section>
		<section class="em-item-meta-column">
			{/no_loc_image}
			<section class="em-taxonomy-description">
				<h3><?php esc_html_e('Description', 'events-manager'); ?></h3>
				#_CATEGORYDESCRIPTION
			</section>
		</section>
	</div>
</section>
<section class="em-taxonomy-events">
	<a name="upcoming-events"></a>
	<h3><?php esc_html_e('Upcoming Events', 'events-manager'); ?></h3>
	#_CATEGORYNEXTEVENTS
</section>