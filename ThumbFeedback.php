<?php
if ( !defined( 'MEDIAWIKI' ) ) {
    die( 'Not an entry point.' );
}

use MediaWiki\MediaWikiServices;

$wgExtensionCredits['other'][] = [
    'path' => __FILE__,
    'name' => 'ThumbFeedback',
    'author' => 'Arkadiusz Mehlich',
    'version' => '1.0.0',
    'description' => 'Prosty system oceny stron łapkami i komentarzem'
];

$wgHooks['BeforePageDisplay'][] = 'ThumbFeedback::onBeforePageDisplay';

class ThumbFeedback {
    public static function onBeforePageDisplay( $out, $skin ) {
        $out->addModules( 'ext.ThumbFeedback' );

        $out->addJsConfigVars( 'ThumbFeedbackMessages', [
            'placeholder' => wfMessage( 'thumbfeedback-placeholder' )->text(),
            'submit' => wfMessage( 'thumbfeedback-submit' )->text(),
            'popupSuccess' => wfMessage( 'thumbfeedback-popup-success' )->text(),
            'errorEmpty' => wfMessage( 'thumbfeedback-error-empty' )->text(),
            'errorSave' => wfMessage( 'thumbfeedback-error-save' )->text()
        ]);

        return true;
    }

    public static function onSchemaUpdate( \DatabaseUpdater $updater ) {
        $dir = __DIR__;
        $updater->addExtensionTable(
            'thumbfeedback',
            "$dir/sql/thumbfeedback.sql"
        );
    }
}

?>