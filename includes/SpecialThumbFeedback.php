<?php

namespace ThumbFeedback;

use SpecialPage;
use Html;
use MediaWiki\MediaWikiServices;

class SpecialThumbFeedback extends SpecialPage {
    public function __construct() {
        parent::__construct( 'ThumbFeedback' );
    }

    public function execute( $subPage ) {
        $this->setHeaders();
        $out = $this->getOutput();
        $out->setPageTitle( 'Komentarze ThumbFeedback' );

        $dbr = wfGetDB( DB_REPLICA );
        $res = $dbr->select(
            'thumbfeedback',
            [ 'tf_id', 'tf_page', 'tf_user', 'tf_vote', 'tf_comment', 'tf_timestamp' ],
            '',
            __METHOD__,
            [ 'ORDER BY' => 'tf_timestamp DESC', 'LIMIT' => 50 ]
        );

        $html = "<table class='wikitable'><tr>
                    <th>ID</th>
                    <th>Strona</th>
                    <th>Użytkownik</th>
                    <th>Głos</th>
                    <th>Komentarz</th>
                    <th>Czas</th>
                 </tr>";

        foreach ( $res as $row ) {
            $vote = $row->tf_vote == 1 ? '👍' : ( $row->tf_vote == -1 ? '👎' : '–' );
            $html .= "<tr>
                        <td>{$row->tf_id}</td>
                        <td><a href='" . htmlspecialchars( $this->getPageUrl( $row->tf_page ) ) . "'>" . htmlspecialchars( $row->tf_page ) . "</a></td>
                        <td>" . htmlspecialchars( $row->tf_user ) . "</td>
                        <td>{$vote}</td>
                        <td>" . htmlspecialchars( $row->tf_comment ) . "</td>
                        <td>{$row->tf_timestamp}</td>
                      </tr>";
        }
        $html .= "</table>";

        $out->addHTML( $html );
    }

    private function getPageUrl( $title ) {
        return \Title::newFromText( $title )->getFullURL();
    }
}
?>