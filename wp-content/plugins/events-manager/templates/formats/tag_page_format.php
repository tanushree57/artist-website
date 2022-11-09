<section class="em-item-header" style="--default-border:#_TAGCOLOR;">
	{has_image}
	<div class="em-item-image">
		#_TAGIMAGE{medium}
	</div>
	{/has_image}
	<div class="em-item-meta">
		<section class="em-item-meta-column">
			<section class="em-location-next-event">
				<h3><?php esc_html_e('Next Event', 'events-manager'); ?></h3>
				{has_events}
				<div class="em-item-meta-line em-taxonomy-events em-tag-events">
					<span class="em-icon-calendar em-icon"></span>
					<div>
						<p>#_TAGNEXTEVENT</p>
						<p><a href="#upcoming-events"><?php esc_html_e('See All', 'events-manager'); ?></a></p>
					</div>
				</div>
				{/has_events}
				{no_events}
				<div class="em-item-meta-line em-taxonomy-no-events em-tag-no-events">
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
				#_TAGDESCRIPTION
			</section>
		</section>
	</div>
</section>
<section class="em-taxonomy-events">
	<a name="upcoming-events"></a>
	<h3><?php esc_html_e('Upcoming Events', 'events-manager'); ?></h3>
	#_TAGNEXTEVENTS
</section>