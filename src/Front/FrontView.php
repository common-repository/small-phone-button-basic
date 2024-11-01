<?php

namespace DG2_Phone_Button\Front;

class FrontView {
	private static $instance = null;

	public function __construct() {
		$this->init();
	}

	public function init() {
		add_action( 'wp_footer', [ $this, 'dg2_add_phone_button' ], 5 );
	}

	function dg2_hex2rgba( $color, $opacity = false ) {

		$default = 'rgb(0,0,0)';

		//Return default if no color provided
		if ( empty( $color ) ) {
			return $default;
		}

		//Sanitize $color if "#" is provided
		if ( $color[0] == '#' ) {
			$color = substr( $color, 1 );
		}

		//Check if color has 6 or 3 characters and get values
		if ( strlen( $color ) == 6 ) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return $default;
		}

		//Convert hexadec to rgb
		$rgb = array_map( 'hexdec', $hex );

		//Check if opacity is set(rgba or rgb)
		if ( $opacity ) {
			if ( abs( $opacity ) > 1 ) {
				$opacity = 1.0;
			}
			$output = 'rgba(' . implode( ",", $rgb ) . ',' . $opacity . ')';
		} else {
			$output = 'rgb(' . implode( ",", $rgb ) . ')';
		}

		//Return rgb(a) color string
		return $output;
	}

	function dg2_add_phone_button() {
		$dg2_phone_call_button_options = get_option( 'dg2_phone_call_button_option_name' ); // Array of All Options
		$phone_0                       = $dg2_phone_call_button_options['phone_0'] ?? ""; // Phone
		$phone_1                       = $dg2_phone_call_button_options['phone_1'] ?? "";
		$color_bg                      = $dg2_phone_call_button_options['color_bg'] ?? "";
		$color_txt                     = $dg2_phone_call_button_options['color_txt'] ?? "";
		$dugme_x                       = $dg2_phone_call_button_options['dugme_x'] ?? "";
		$dugme_y                       = $dg2_phone_call_button_options['dugme_y'] ?? "";
		$choose_icon_1                 = $dg2_phone_call_button_options['choose_icon_1'] ?? "icon1";
		$button_type                   = $dg2_phone_call_button_options['button_type_2'] ?? "circle";
		$dg2_btn_desktop               = $dg2_phone_call_button_options['dg2_btn_desktop'] ?? false;
		if ( $choose_icon_1 != "" ) {
			$image = $this->return_image( $choose_icon_1, $color_txt );
		}


		echo '<style>';
		echo "@keyframes pulse {
            0% {
              transform: scale(0.95);
              box-shadow: 0 0 0 0 " . $this->dg2_hex2rgba( esc_attr( $color_bg ), 0.7 ) . ";
            }
          
            10% {
              transform: scale(1);
              box-shadow: 0 0 0 10px " . $this->dg2_hex2rgba( esc_attr( $color_bg ), 0.001 ) . ";
            }
          
            20%,
            100% {
              transform: scale(0.95);
              box-shadow: 0 0 0 0 " . $this->dg2_hex2rgba( esc_attr( $color_bg ), 0.001 ) . ";
            }
          }
          .svg-color{
              fill:" . esc_attr( $color_txt ) . "
          }";
		if ( ! isset( $dg2_btn_desktop ) ) {
			echo '@media (min-width:990px){.dg2-phone-button-float{display:none;}}';
		}
		if ( $button_type == "square" ) {
			echo '.dg2-phone-button-float{border-radius:5px;}';
		}
		if ( $button_type == "squaresharp" ) {
			echo '.dg2-phone-button-float{border-radius:0;}';
		}
		if ( $phone_1 != "" ) {
			echo '.dg2-phone-button-float:hover{padding-left:20px;padding-right:20px;}.dg2-phone-button-float:hover span{padding-left:10px;}';
		} else {
			echo '.dg2-phone-button-float:hover{padding-left:10px;padding-right:10px;}';
		}
		echo '</style>';

		$svg_args = array(
			'svg'   => array(
				'class'             => true,
				'aria-hidden'       => true,
				'aria-labelledby'   => true,
				'role'              => true,
				'stroke'            => true,
				'stroke-linecap'    => true,
				'stroke-linejoin'   => true,
				'enable-background' => true,
				'xmlns'             => true,
				'width'             => true,
				'height'            => true,
				'viewbox'           => true, // <= Must be lower case!
			),
			'g'     => array( 'fill' => true ),
			'title' => array( 'title' => true ),
			'path'  => array( 'd' => true, 'fill' => true, 'class' => true ),
			'rect'  => array( 'class' => true, 'x' => true, 'y' => true, 'width' => true, 'height' => true, )
		);

		printf(
			'<a href="tel:%s" class="dg2-phone-button-float" style="background:%s;bottom: %spx;right: %spx;">%s<span style="color:%s">%s</span></a>',
			esc_html( $phone_0 ),
			esc_attr( $color_bg ),
			esc_attr( $dugme_y ),
			esc_attr( $dugme_x ),
			wp_kses( $image, $svg_args ),
			esc_attr( $color_txt ),
			esc_html( $phone_1 )
		);
	}

	function return_image( $style, $color ) {
		switch ( $style ) {
			case "icon1":
				{
					return '<svg height="48" class="svg-color" viewBox="0 0 48 48" width="48" xmlns="http://www.w3.org/2000/svg" ><path d="M0 0h48v48h-48z" fill="none"/><path d="M13.25 21.59c2.88 5.66 7.51 10.29 13.18 13.17l4.4-4.41c.55-.55 1.34-.71 2.03-.49 2.24.74 4.65 1.14 7.14 1.14 1.11 0 2 .89 2 2v7c0 1.11-.89 2-2 2-18.78 0-34-15.22-34-34 0-1.11.9-2 2-2h7c1.11 0 2 .89 2 2 0 2.49.4 4.9 1.14 7.14.22.69.06 1.48-.49 2.03l-4.4 4.42z"/></svg>';
				}
				break;
			case "icon2":
				{
					return '<svg fill="none" height="24" stroke="' . esc_attr( $color ) . '"  stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>';
				}
				break;
			case "icon3":
				{
					return '<svg enable-background="new 0 0 64 64" class="svg-color" style="fill:' . esc_attr( $color ) . '" height="64px" id="Layer_1" version="1.1" viewBox="0 0 64 64" width="64px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M41.883,27.817c0,0-1.479-1.715-2.495-1.715h-0.845v-3.949c0-1.104-0.896-2-2-2s-2,0.896-2,2v3.949h-5.085v-3.949   c0-1.104-0.896-2-2-2s-2,0.896-2,2v3.949h-0.847c-1.016,0-2.494,1.715-2.494,1.715L11.175,38.033   c-0.419,0.392-0.76,1.107-0.76,1.598v0.888v11.735c0,2.028,1.646,3.673,3.674,3.673h35.823c2.028,0,3.673-1.645,3.673-3.673V40.519   c0,0,0-0.396,0-0.888c0-0.49-0.341-1.206-0.76-1.598L41.883,27.817z M48.585,50.927h-33.17V40.915l10.114-9.443l0.177-0.161   l0.177-0.205c0.001-0.001,0.002-0.002,0.003-0.004h12.227l0.16,0.185l0.197,0.184l10.114,9.443V50.927z"/><path d="M40.127,8.073H23.873c-8.283,0-15.001,6.718-15.001,15.003v2.004c0,0.565,0.458,1.022,1.024,1.022h9.211   c1.381,0,2.501-1.118,2.501-2.5v-5.153c0-1.38,1.119-2.5,2.5-2.5h15.783c1.381,0,2.501,1.12,2.501,2.5v5.153   c0,1.382,1.119,2.5,2.5,2.5h9.213c0.565,0,1.022-0.457,1.022-1.022v-2.004C55.128,14.791,48.412,8.073,40.127,8.073z"/><path d="M32,33.638c-4.214,0-7.632,3.418-7.632,7.632c0,4.215,3.418,7.632,7.632,7.632c4.215,0,7.632-3.417,7.632-7.632   C39.632,37.056,36.215,33.638,32,33.638z M32,43.133c-1.029,0-1.863-0.834-1.863-1.863s0.834-1.863,1.863-1.863   s1.863,0.834,1.863,1.863S33.029,43.133,32,43.133z"/></g></svg>';
				}
				break;
			case "icon4":
				{
					return '<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><g data-name="Layer 41" id="Layer_41"><path class="svg-color" d="M23,31H9a3,3,0,0,1-3-3V4A3,3,0,0,1,9,1H23a3,3,0,0,1,3,3V28A3,3,0,0,1,23,31ZM9,3A1,1,0,0,0,8,4V28a1,1,0,0,0,1,1H23a1,1,0,0,0,1-1V4a1,1,0,0,0-1-1Z"/><path class="svg-color" d="M25,7H7A1,1,0,0,1,7,5H25a1,1,0,0,1,0,2Z"/><path class="svg-color" d="M25,25H7a1,1,0,0,1,0-2H25a1,1,0,0,1,0,2Z"/><rect class="svg-color" height="2" width="2" x="15" y="26"/></g></svg>';
				}
				break;
			case "icon5":
				{
					return '<svg enable-background="new 0 0 500 500"  viewBox="0 0 500 500" width="500px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M250,31.949c-77.679,0-155.545,13.902-183.798,41.611  c-23.441,22.988-31.255,63.599-33.889,89.312c0,0-0.363,2.541-0.363,3.634c0,10.083,8.175,18.17,18.17,18.17  c1.181,0,44.882-3.544,71.229-5.724c0.634-0.092,1.273-0.182,1.907-0.363c9.813-0.271,17.719-8.268,17.719-18.17l0.088-35.798  c0-11.084,8.998-19.989,20.083-19.989h177.707c11.087,0,20.086,8.904,20.086,19.989l0.089,35.798c0,9.902,7.905,17.899,17.717,18.17  c0.63,0.182,1.269,0.271,1.91,0.363c26.349,2.179,70.049,5.724,71.226,5.724c9.991,0,18.172-8.087,18.172-18.17  c0-1.093-0.363-3.634-0.363-3.634c-2.636-25.713-10.441-66.323-33.883-89.312C405.545,45.851,327.679,31.949,250,31.949z   M250,268.172c-20.079,0-36.342,16.262-36.342,36.341s16.263,36.34,36.342,36.34s36.341-16.261,36.341-36.34  S270.079,268.172,250,268.172z M222.744,186.401v-22.713c0-12.537-10.177-22.713-22.713-22.713s-22.713,10.177-22.713,22.713v22.713  L54.75,317.324c-8.446,8.269-13.717,19.804-13.717,32.527v36.433c0,20.079,16.264,36.34,36.342,36.34h9.086v22.716  c0,12.536,10.178,22.711,22.714,22.711s22.713-10.175,22.713-22.711v-22.716h236.224v22.716c0,12.536,10.174,22.711,22.715,22.711  c12.536,0,22.711-10.175,22.711-22.711v-22.716h9.086c20.079,0,36.341-16.261,36.341-36.34v-36.433  c0-12.724-5.27-24.259-13.717-32.527L322.685,186.401v-22.713c0-12.537-10.179-22.713-22.715-22.713s-22.712,10.177-22.712,22.713  v22.713H222.744z M250,231.83c40.158,0,72.685,32.526,72.685,72.683c0,40.158-32.526,72.686-72.685,72.686  c-40.158,0-72.683-32.527-72.683-72.686C177.317,264.355,209.842,231.83,250,231.83z" class="svg-color"/></svg>';
				}
				break;
			case "icon6":
				{
					return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72.31 81.67"><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="svg-color" d="M51.83,81.67A16.14,16.14,0,0,1,49,81.43c-8.84-1-21.87-13.53-31.13-24.91-6.51-8-11.71-16.24-14.64-23.2C.81,28-.27,23.64.06,20.39.56,8.55,13.63,1.27,15.12.48L16,0l2.53,3.88L21.47,8.2l5.14,7.61,0,.06c.07.11.13.22.2.35a4.82,4.82,0,0,1-.28,5.92,4.55,4.55,0,0,1-.88,1L23.36,25l-4,3.51c-.68.58-.65.78-.51,1l16.6,21.26,8.17,9.82c.51.56.87.62,2-.08l3.83-2.85,2.72-2.15a4.79,4.79,0,0,1,5.6-.26,4.6,4.6,0,0,1,1,.85c.12.09.21.18.3.26l0,.05,6.35,6.64c1.78,1.87,3.46,3.63,3.62,3.78l0,0,3.2,3.26-.66.77C70.65,72.12,62.24,81.67,51.83,81.67ZM15.28,2.94c-5.06,2.95-12.66,9.45-13,17.58v.07c-.29,2.81.75,6.9,3,11.83,2.87,6.81,8,14.86,14.33,22.69C30.9,69,42.55,78.46,49.28,79.22h.07c8,1.4,16-4.65,19.93-9l-1.76-1.78c-.2-.2-.92-1-3.67-3.84L57.52,58l-.15-.13-.12-.08-.09-.11a2.66,2.66,0,0,0-.64-.51,2.58,2.58,0,0,0-3,.11l-2.75,2.18-4,2.94c-.72.46-2.9,1.87-4.87-.3l0,0-8.2-9.87L17,30.79l0-.08c-.76-1.39-.43-2.7,1-3.89l4-3.52,2.35-1.93a2.47,2.47,0,0,0,.49-.55l.09-.11A2.58,2.58,0,0,0,25,17.46l-.09-.12-.05-.13-.1-.18L19.62,9.45c-2.24-3.31-2.82-4.17-3-4.41Z"/></g></g></svg>';
				}
				break;
			case "icon7":
				{
					return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 62.87 71.35"><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="svg-color" d="M60.62,59.75c-.16-.14-5.68-6-9-9.44a3,3,0,0,0-.27-.23,3.4,3.4,0,0,0-.81-.67,3.31,3.31,0,0,0-3.88.18l-2.48,2-3.48,2.59c-1,.63-2,1.09-3.1-.09l-7.4-8.91-15-19.24c-.46-.83-.26-1.49.65-2.26l3.65-3.18,2.1-1.72a3.53,3.53,0,0,0,.63-.71,3.33,3.33,0,0,0,.17-4.21,3.07,3.07,0,0,0-.17-.31c-2.69-4-7.2-10.65-7.3-10.83L13.1,0C9,2.2.4,8.53.05,17.15c-.3,2.92.8,6.84,2.78,11.2,2.7,6.4,7.5,13.85,13.06,20.68,9,11,20.26,21.31,27.45,22.12,8.49,1.48,16.5-5.54,19.53-9.12Z"/></g></g></svg>';
				}
				break;
			default:
				{
					return '<svg height="48" class="svg-color" viewBox="0 0 48 48" width="48" xmlns="http://www.w3.org/2000/svg" ><path d="M0 0h48v48h-48z" fill="none"/><path d="M13.25 21.59c2.88 5.66 7.51 10.29 13.18 13.17l4.4-4.41c.55-.55 1.34-.71 2.03-.49 2.24.74 4.65 1.14 7.14 1.14 1.11 0 2 .89 2 2v7c0 1.11-.89 2-2 2-18.78 0-34-15.22-34-34 0-1.11.9-2 2-2h7c1.11 0 2 .89 2 2 0 2.49.4 4.9 1.14 7.14.22.69.06 1.48-.49 2.03l-4.4 4.42z"/></svg>';
				}
				break;
		}
	}


	/**
	 * Instance
	 * @access public
	 * @return object $instance of the class
	 */
	static public function getInstance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
