import { registerBlockType } from '@wordpress/blocks';

registerBlockType( 'bdaylove/trigger-button', {
	title: 'Trigger Button',
	icon: 'button',
	category: 'widgets',
	edit: () => (
		<a href="#" className="trigger-bday-widget wp-element-button">
			Rezerwuj
		</a>
	),
	save: () => (
		<a href="#" className="trigger-bday-widget wp-element-button">
			Rezerwuj
		</a>
	),
} );
