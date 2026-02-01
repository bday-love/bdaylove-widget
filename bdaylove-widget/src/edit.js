import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, SelectControl, Placeholder } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { widgetId, widgetMode } = attributes;

	return (
		<div { ...useBlockProps() }>
			<InspectorControls>
				<PanelBody title={ __( 'Ustawienia', 'bdaylove-widget' ) }>
					<TextControl
						label={ __( 'Identyfikator Widgetu', 'bdaylove-widget' ) }
						value={ widgetId || '' }
						onChange={ ( val ) => setAttributes( { widgetId: val } ) }
						help={ __( 'Pozostaw puste, aby użyć domyślnego ID.', 'bdaylove-widget' ) }
					/>
					<SelectControl
						label={ __( 'Tryb wyświetlania', 'bdaylove-widget' ) }
						value={ widgetMode }
						options={ [
							{ label: __( 'Kalendarz w treści', 'bdaylove-widget' ), value: 'inline' },
							{ label: __( 'Przycisk (Modal)', 'bdaylove-widget' ), value: 'modal' },
						] }
						onChange={ ( val ) => setAttributes( { widgetMode: val } ) }
					/>
				</PanelBody>
			</InspectorControls>

			<Placeholder
				icon="calendar"
				label={ __( 'Widget Bday Love', 'bdaylove-widget' ) }
				instructions={ __( 'Skonfiguruj widget w pasku bocznym.', 'bdaylove-widget' ) }
			>
				<div style={ { marginTop: '10px' } }>
					<strong>{ __( 'Wybrane ID:', 'bdaylove-widget' ) }</strong> { widgetId || __( '(Domyślne)', 'bdaylove-widget' ) }
					<br />
					<strong>{ __( 'Tryb:', 'bdaylove-widget' ) }</strong> { widgetMode }
				</div>
			</Placeholder>
		</div>
	);
}
