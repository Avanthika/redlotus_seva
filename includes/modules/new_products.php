<style type="text/css">
body
{
   color: #000000;
}
</style>
<style type="text/css">
a
{
   color:#000000;
   text-decoration:none;
}
a:active
{
   color:#000000;
}
a:hover
{
   color:#000000;
   text-decoration: underline;
}
</style>
<link rel="stylesheet" href="cupertino/jquery.ui.all.css" type="text/css">
<style type="text/css">
#jQueryTabs1
{
   padding: 4px 4px 4px 4px;
}
#jQueryTabs1 .ui-tabs-nav
{
   font-family: Arial;
   font-size: 16px;
   padding: 4px 4px 0px 4px;
}
#jQueryTabs1 .ui-tabs-nav li
{
   font-weight: normal;
   font-style: normal;
   margin: 0px 2px -1px 0px;
}
#jQueryTabs1 .ui-tabs-nav li a
{
   padding: 8px 10px 8px 10px;
}
</style>
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="jquery.ui.core.min.js"></script>
<script type="text/javascript" src="jquery.ui.widget.min.js"></script>
<script type="text/javascript" src="jquery.ui.mouse.min.js"></script>
<script type="text/javascript" src="jquery.ui.sortable.min.js"></script>
<script type="text/javascript" src="jquery.ui.tabs.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
   var jQueryTabs1Opts =
   {
      fx:
      {
         opacity: 'toggle',
         duration: 'normal'
      },
      event: 'mouseover',
      collapsible: false
   };
   $("#jQueryTabs1").tabs(jQueryTabs1Opts);
   $("#jQueryTabs1").tabs('rotate', 5000, false);
});
</script>
</head>
<body>
<div id="jQueryTabs1">
<ul>
<li><a href="#jquerytabs1-page-0"><span><font color="#000000">Deals</font></span></a></li>
<li><a href="#jquerytabs1-page-1"><span><font color="#000000">New</font></span></a></li>
</ul>
<div style="height:318px;overflow:auto;padding:0;" id="jquerytabs1-page-0">
<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

 
$new_deals_query=tep_db_query("select distinct p.products_id,p.products_price,p.products_image,pd.products_name,sp.specials_new_products_price from ".TABLE_PRODUCTS." p join ".TABLE_SPECIALS." sp join ".TABLE_PRODUCTS_DESCRIPTION." pd where p.products_id=sp.products_id and p.products_id=pd.products_id");
   

  $num_new_deals = tep_db_num_rows($new_deals_query);
  

  if ($new_deals_query > 0) {
    $count = 0;
	$column = 0;
	
    $new_deals_content = '<table border="0" width="100%" cellspacing="0" cellpadding="2">';
    while ($new_deals = tep_db_fetch_array($new_deals_query)) {
      $count++;

      if ($column === 0) {
        $new_prods_content .= '<tr>';
      }
	  
	  $new_deals_content .= '<td width="33%" align="center" valign="top"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_deals['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $new_deals['products_image'], $new_deals['products_name'], SMALL_IMAGE_WIDTH+20, SMALL_IMAGE_HEIGHT+20) . '</a><br /><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_deals['products_id']) . '">' . $new_deals['products_name'] . '</a><br /><strike>' .$currencies->display_price($new_deals['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</strike><br /><font color="#FF0000">' .$currencies->display_price($new_deals['specials_new_products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])).'</font></td>';

      $column ++;

      if (($column > 2) || ($count == $num_new_deals)) {
        $new_deals_content .= '</tr>';

        $column = 0;
      }
    }

    $new_deals_content .= '</table>';
?>

  <h2><?php echo "TODAY DEALS"; ?></h2>

  <div class="contentText">
    <?php echo $new_deals_content; ?>
  </div>

<?php
  }
?>


</div>
<div style="height:512px;overflow:auto;padding:0;" id="jquerytabs1-page-1">
<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  if ( (!isset($new_products_category_id)) || ($new_products_category_id == '0') ) {
    $new_products_query = tep_db_query("select p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, if(s.status, s.specials_new_products_price, p.products_price) as products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_date_added desc limit " . MAX_DISPLAY_NEW_PRODUCTS);
  } else {
    $new_products_query = tep_db_query("select distinct p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, if(s.status, s.specials_new_products_price, p.products_price) as products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and c.parent_id = '" . (int)$new_products_category_id . "' and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_date_added desc limit " . MAX_DISPLAY_NEW_PRODUCTS);
  }
   

  $num_new_products = tep_db_num_rows($new_products_query);
  

  if ($new_products_query > 0) {
    $counter = 0;
	$col = 0;
	
    $new_prods_content = '<table border="0" width="100%" cellspacing="0" cellpadding="2">';
    while ($new_products = tep_db_fetch_array($new_products_query)) {
      $counter++;

      if ($col === 0) {
        $new_prods_content .= '<tr>';
      }
	  
	  $new_prods_content .= '<td width="33%" align="center" valign="top"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $new_products['products_image'], $new_products['products_name'], SMALL_IMAGE_WIDTH+20, SMALL_IMAGE_HEIGHT+20) . '</a><br /><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">' . $new_products['products_name'] . '</a><br />' . $currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</td>';

      $col ++;

      if (($col > 2) || ($counter == $num_new_products)) {
        $new_prods_content .= '</tr>';

        $col = 0;
      }
    }

    $new_prods_content .= '</table>';
?>

  <h2><?php echo sprintf(TABLE_HEADING_NEW_PRODUCTS, strftime('%B')); ?></h2>

  <div class="contentText">
    <?php echo $new_prods_content; ?>
 </div>
<?php
}
?>
</div>
</div>


