jQuery( function() {
    jQuery( '.cms-preview' ).entwine( '.ss.preview' ).changeMode( 'content' );
    jQuery( '.cms-preview' ).entwine( '.ss.preview' ).disablePreview();
    jQuery( '.preview-mode-selector' ).remove();
} );