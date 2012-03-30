<?php

class HLT_DashboardRssWidget {

	protected $m_aFeeds;

	public function __construct() {
		$this->m_aFeeds = array();
		
		$this->addFeed( 'hlt', 'http://www.hostliketoast.com/feed/' );
		
		add_action( 'wp_dashboard_setup', array( $this, 'addNewsWidget' ) );
	}

	public function HLT_DashboardRssWidget() {
		$this->__construct();
	}
	
	public function addFeed( $insReference, $insUrl ) {
		$this->m_aFeeds[$insReference] = $insUrl;
	}

	public function addNewsWidget() {
		add_meta_box( 'hlt_news_widget', __( 'The Host Like Toast Blog', 'hlt' ), array( $this, 'renderNewsWidget' ), 'dashboard', 'normal', 'low' );
	}

	public function renderNewsWidget() {
		$oRss = fetch_feed( $this->m_aFeeds['hlt'] );
		
		if ( !is_wp_error( $oRss ) ) {
			$nMaxItems = $oRss->get_item_quantity( 5 );
			$aItems = $oRss->get_items( 0, $nMaxItems );
		}
		
		$sRssWidget = '<div class="hlt_rss_widget"><ul>';
		
		if ( !empty( $aItems ) ) {
			$sDateFormat = get_option( 'date_format' );
			
			foreach ( $aItems as $oItem ) {
				$sRssWidget .= '
					<li>
						<span class="hlt_rss_date">'.esc_attr__( $oItem->get_date( $sDateFormat ), 'hlt' ).'</span>
						<a class="hlt_rss_link"
							href="'.esc_url( $oItem->get_permalink() ).'"
							title="'.esc_attr__( $oItem->get_description(), 'hlt' ).'">'.esc_attr__( $oItem->get_title(), 'hlt' ).'</a>
					</li>';
			}
		}
		else {
			$sRssWidget .= '<li><a href="'.$this->m_aFeeds['hlt'].'">'.__('Check out the The Host Like Toast Blog!').'</a></li>';
		}

		$sRssWidget .= '</ul></div>';
		
		echo $sRssWidget;
	}
}//class HLT_DashboardRssWidget
