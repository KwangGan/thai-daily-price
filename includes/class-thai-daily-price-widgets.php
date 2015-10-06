<?php



// Creating the widget 

class Thai_Daily_Price_Widgets extends WP_Widget {



function __construct() {

parent::__construct(

// Base ID of your widget

'Thai_Daily_Price_Widgets', 



// Widget name will appear in UI

__('Thai Daily Oil Price', 'daily_widget_domain'), 



// Widget description

array( 'description' => __( 'แสดงผลราคาน้ำมันจากบางจาก', 'th_oil_widget_domain' ), ) 

);

}



// Creating widget front-end

// This is where the action happens

public function widget( $args, $instance ) {

// Check and store cache data 1800 = 30 min / 3600 = 1 hr
$theBody =null;
if ( false === ( $theBody = get_transient( 'oldprice' ) ) ) {
  $theBody = wp_remote_retrieve_body(wp_remote_get('http://www.bangchak.co.th/oilprice-widget.aspx') );
  if (set_transient('oldprice',$theBody,3600)) {
  }
}

// New Dom extractor
 $html = new simple_html_dom();
 $html->load($theBody);


//Widget Start
$title = apply_filters( 'widget_title', $instance['title'] );

// before and after widget arguments are defined by themes

echo $args['before_widget'];

if ( ! empty( $title ) )

echo $args['before_title'] . $title . $args['after_title'];





$elements = $html->find('td');
// Calcucate indicator of price
if (!is_null($elements[5]->plaintext)) {
$indi_low ="price-low";
$indi_high ="price-high";
 $indi_diesel = $elements[5]->plaintext == $elements[6]->plaintext ? "" : ( $elements[5]->plaintext > $elements[6]->plaintext ? $indi_low : $indi_high );
 
  $indi_e85 = $elements[8]->plaintext == $elements[9]->plaintext ? "" : ( $elements[8]->plaintext > $elements[9]->plaintext ? $indi_low : $indi_high );

  $indi_e20 = $elements[11]->plaintext == $elements[12]->plaintext ? "" : ( $elements[11]->plaintext > $elements[12]->plaintext ? $indi_low : $indi_high );

  $indi_sol91 = $elements[14]->plaintext == $elements[15]->plaintext ? "" : ( $elements[14]->plaintext > $elements[15]->plaintext ? $indi_low : $indi_high );

  $indi_sol95 = $elements[17]->plaintext == $elements[18]->plaintext ? "" : ( $elements[17]->plaintext > $elements[18]->plaintext ? $indi_low : $indi_high );

  $indi_ngv = $elements[21]->plaintext == $elements[22]->plaintext ? "" : ( $elements[21]->plaintext > $elements[22]->plaintext ? $indi_low : $indi_high );



?>

<table>

  <tr>

    <th colspan="3" class="price">อัพเดตล่าสุด <?php echo $elements[2]->plaintext; ?></th>

  </tr>

  <tr>

    <td>ประเภท</td>

    <td class="price">ราคาวันนี้</td>

    <td class="price">พรุ่งนี้</td>

  </tr>

  <tr >

    <td class="diesel">ดีเซล</td>

    <td class="price"><?php echo $elements[5]->plaintext; ?></td>

    <td class="price <?php  echo $indi_diesel; ?>"><?php echo $elements[6]->plaintext;  ?></td>

  </tr>

  <tr >

    <td class="e85">E85</td>

    <td class="price"><?php echo $elements[8]->plaintext; ?></td>

    <td class="price <?php  echo $indi_e85; ?>"><?php echo $elements[9]->plaintext; ?></td>

  </tr>

  <tr>

       <td class="e20">E20</td>

    <td class="price"><?php echo $elements[11]->plaintext; ?></td>

    <td class="price <?php  echo $indi_e20; ?>"><?php echo $elements[12]->plaintext; ?></td>

   

  </tr>

  <tr >

    <td class="so91">โซฮอล 91</td>

    <td class="price"><?php echo $elements[14]->plaintext; ?></td>

    <td class="price <?php  echo $indi_sol91; ?>"><?php echo $elements[15]->plaintext;  ?></td>

  </tr>

  <tr >

    <td class="so95">โซฮอล 95</td>

     <td class="price"><?php echo $elements[17]->plaintext; ?></td>

    <td class="price <?php  echo $indi_sol95; ?>"><?php echo $elements[18]->plaintext; ?></td>

  </tr>

  <tr >

    <td class="ngv">NGV</td>

      <td class="price"><?php echo $elements[21]->plaintext; ?></td>

    <td class="price <?php  echo $indi_ngv; ?>"><?php echo $elements[22]->plaintext;  ?></td>

  </tr>

    <tr>

    <td colspan="3" class="price"><a href="http://www.bangchak.co.th/th/service-stations.aspx">ขอขอบคุณข้อมูลจาก ปั๊มน้ำมันบางจาก</a></td>


  </tr>

</table>

<?php

    // code...

}

echo $args['after_widget'];

}

		

// Widget Backend 

public function form( $instance ) {

if ( isset( $instance[ 'title' ] ) ) {

$title = $instance[ 'title' ];

}

else {

$title = __( 'New title', 'wpb_widget_domain' );

}

// Widget admin form

?>

<p>

<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 

<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

</p>

<?php 

}

	

// Updating widget replacing old instances with new

public function update( $new_instance, $old_instance ) {

$instance = array();

$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

return $instance;

}



public function Thai_Daily_Price_load_widget() {

	register_widget( 'Thai_Daily_Price_Widgets' );

}





public function wp_log_http_requests( $response, $args, $url ) {



	// set your log file location here

	$logfile = plugin_dir_path( __FILE__ ) . '/http_requests.log';



	// parse request and response body to a hash for human readable log output

	$log_response = $response;

	if ( isset( $args['body'] ) ) {

		parse_str( $args['body'], $args['body_parsed'] );

	}

	if ( isset( $log_response['body'] ) ) {

		parse_str( $log_response['body'], $log_response['body_parsed'] );

	}

	// write into logfile

	file_put_contents( $logfile, sprintf( "### %s, URL: %s\nREQUEST: %sRESPONSE: %s\n", date( 'c' ), $url, print_r( $args, true ), print_r( $log_response, true ) ), FILE_APPEND );



	return $response;

}



} // Class wpb_widget ends here



// Register and load the widget



