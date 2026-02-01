import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, SelectControl, Placeholder } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { widgetId, widgetMode } = attributes;

	return (
		<div { ...useBlockProps() }>
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'bdaylove-widget' ) }>
					<TextControl
						label={ __( 'Widget ID', 'bdaylove-widget' ) }
						value={ widgetId || '' }
						onChange={ ( val ) => setAttributes( { widgetId: val } ) }
						help={ __( 'Leave empty to use the global default ID.', 'bdaylove-widget' ) }
					/>
					<SelectControl
						label={ __( 'Display Mode', 'bdaylove-widget' ) }
						value={ widgetMode }
						options={ [
							{ label: __( 'Inline Calendar', 'bdaylove-widget' ), value: 'inline' },
							{ label: __( 'Modal Button', 'bdaylove-widget' ), value: 'modal' },
						] }
						onChange={ ( val ) => setAttributes( { widgetMode: val } ) }
					/>
				</PanelBody>
			</InspectorControls>

			<Placeholder
				icon="calendar"
				label={ __( 'Bday Love Widget', 'bdaylove-widget' ) }
				instructions={ __( 'Configure the widget in the sidebar.', 'bdaylove-widget' ) }
			>
				<div style={ { marginTop: '10px' } }>
					<strong>{ __( 'Selected ID:', 'bdaylove-widget' ) }</strong> { widgetId || __( '(Default)', 'bdaylove-widget' ) }
					<br />
					<strong>{ __( 'Mode:', 'bdaylove-widget' ) }</strong> { widgetMode }
				</div>
			</Placeholder>
		</div>
	);
}
