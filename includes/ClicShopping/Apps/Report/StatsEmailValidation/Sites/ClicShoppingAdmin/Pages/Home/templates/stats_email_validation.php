<?php
  /**
   *
   * @copyright 2008 - https://www.clicshopping.org
   * @Brand : ClicShopping(Tm) at Inpi all right Reserved
   * @Licence GPL 2 & MIT
   * @licence MIT - Portion of osCommerce 2.4
   * @Info : https://www.clicshopping.org/forum/trademark/
   *
   */

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;

  $CLICSHOPPING_Template = Registry::get('TemplateAdmin');
  $CLICSHOPPING_Mail = Registry::get('Mail');

  $CLICSHOPPING_StatsEmailValidation = Registry::get('StatsEmailValidation');
  $CLICSHOPPING_Page = Registry::get('Site')->getPage();

  ini_set('max_execution_time', 0); // Aucune limite d'execution

  $page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? (int)$_GET['page'] : 1;

  $listingTotalRow = 0;
?>
<div class="contentBody">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-block headerCard">
        <div class="row">
          <span
            class="col-md-1 logoHeading"><?php echo HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'categories/stats_email.png', $CLICSHOPPING_StatsEmailValidation->getDef('heading_title'), '40', '40'); ?></span>
          <span
            class="col-md-5 pageHeading"><?php echo '&nbsp;' . $CLICSHOPPING_StatsEmailValidation->getDef('heading_title'); ?></span>
          <span class="col-md-6 text-end">
<?php
  echo HTML::button($CLICSHOPPING_StatsEmailValidation->getDef('button_reset'), null, $CLICSHOPPING_StatsEmailValidation->link('StatsEmailValidation&Reset'), 'danger') . '&nbsp;';
  echo HTML::button($CLICSHOPPING_StatsEmailValidation->getDef('button_analyse'), null, $CLICSHOPPING_StatsEmailValidation->link('StatsEmailValidation&Analyse'), 'success') . '&nbsp;';
  echo HTML::button($CLICSHOPPING_StatsEmailValidation->getDef('button_cancel'), null, $CLICSHOPPING_StatsEmailValidation->link('StatsEmailValidation'), 'warning');
?>
            </span>
        </div>
      </div>
    </div>
  </div>
  <div class="separator"></div>
  <div class="separator"></div>
  <table border="0" width="100%" cellspacing="0" cellpadding="2">
    <td>
      <table class="table table-sm table-hover table-striped">
        <thead>
        <tr class="dataTableHeadingRow">
          <th><?php echo $CLICSHOPPING_StatsEmailValidation->getDef('table_heading_customers_id'); ?></th>
          <th><?php echo $CLICSHOPPING_StatsEmailValidation->getDef('table_heading_first_name'); ?></th>
          <th><?php echo $CLICSHOPPING_StatsEmailValidation->getDef('table_heading_last_name'); ?></th>
          <th><?php echo $CLICSHOPPING_StatsEmailValidation->getDef('table_heading_address_email'); ?>&nbsp;</th>
          <th><?php echo $CLICSHOPPING_StatsEmailValidation->getDef('table_heading_validate_email'); ?>&nbsp;</th>
          <th class="text-end"><?php echo $CLICSHOPPING_StatsEmailValidation->getDef('table_heading_clear'); ?>
            &nbsp;
          </th>
        </tr>
        </thead>
        <tbody>
        <?php
          if (isset($_GET['Analyse'])) {

          $QvalidationEmail = $CLICSHOPPING_StatsEmailValidation->db->prepare('select  SQL_CALC_FOUND_ROWS customers_id,
                                                                customers_email_address,
                                                                customers_firstname,
                                                                customers_lastname,
                                                                customers_email_validation
                                   from :table_customers
                                   where customers_email_validation = 0
                                   limit :page_set_offset,
                                        :page_set_max_results
                                  ');

          $QvalidationEmail->setPageSet((int)MAX_DISPLAY_SEARCH_RESULTS_ADMIN);
          $QvalidationEmail->execute();


          $listingTotalRow = $QvalidationEmail->getPageSetTotalRows();
          $rows = 0;

          if ($listingTotalRow > 0) {

            while ($QvalidationEmail->fetch()) {

              $rows++;

              $email_validation = $CLICSHOPPING_Mail->validateDomainEmail($QvalidationEmail->value('customers_email_address'));

              if ($email_validation != 1) {
                $Qupdate = $CLICSHOPPING_StatsEmailValidation->db->prepare('update :table_customers
                                                              set customers_email_validation = 1
                                                              where customers_email_address = :customers_email_address
                                                              ');
                $Qupdate->bindValue(':customers_email_address', $email_validation);

                $Qupdate->execute();
              }

              if (strlen($rows) < 2) {
                $rows = '0' . $rows;
              }
              ?>
              <tr onMouseOver="rowOverEffect(this)" onMouseOut="rowOutEffect(this)"">
              <th scope="row"><?php echo $QvalidationEmail->valueInt('customers_id'); ?></th>
              <td><?php echo $QvalidationEmail->value('customers_firstname'); ?></td>
              <td><?php echo $QvalidationEmail->value('customers_lastname'); ?></td>
              <td><?php echo $QvalidationEmail->value('customers_email_address'); ?></td>
              <td>
                <?php
                  if ($email_validation == 1) echo $CLICSHOPPING_StatsEmailValidation->getDef('text_success_domain');
                  if ($email_validation != 1) echo $CLICSHOPPING_StatsEmailValidation->getDef('text_no_success_domain');
                ?>
              </td>
              <td class="text-end">
                <?php
                  echo HTML::link(CLICSHOPPING::link(null, 'A&Customers\Customers&Edit&cID=' . $QvalidationEmail->valueInt('customers_id') . '&action=edit'), HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'icons/edit.gif', $CLICSHOPPING_StatsEmailValidation->getDef('icon_edit'))) . '&nbsp';
                  echo HTML::link(CLICSHOPPING::link(null, 'A&Customers\Customers&Customers&DeletecID=' . $QvalidationEmail->valueInt('customers_id') . '&action=confirm'), HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'icons/delete.gif', $CLICSHOPPING_StatsEmailValidation->getDef('icon_delete')));
                ?>&nbsp;
              </td>
              </tr>
              <?php

            } // end while
          } // end $listingTotalRow
        ?>
        </tbody>
      </table>
    </td>
    </tr>
    <?php
      } else {
      ?>
      <tr>
        <div class="separator"></div>
        <div class="alert alert-info" role="alert">
          <div><?php echo HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'icons/help.gif', $CLICSHOPPING_StatsEmailValidation->getDef('title_help_email_image')) . ' ' . $CLICSHOPPING_StatsEmailValidation->getDef('title_help_email_image') ?></div>
          <div class="separator"></div>
          <div><?php echo $CLICSHOPPING_StatsEmailValidation->getDef('title_text_help_email'); ?></div>
        </div>
      </tr>
      <?php
    }
    ?>
  </table>
  <?php
    if ($listingTotalRow > 0) {
      ?>
      <div class="row">
        <div class="col-md-12">
          <div
            class="col-md-6 float-start pagenumber hidden-xs TextDisplayNumberOfLink"><?php echo $QvalidationEmail->getPageSetLabel($CLICSHOPPING_StatsEmailValidation->getDef('text_display_number_of_link')); ?></div>
          <div
            class="float-end text-end"> <?php echo $QvalidationEmail->getPageSetLinks(CLICSHOPPING::getAllGET(array('page', 'info', 'x', 'y'))); ?></div>
        </div>
      </div>
      <?php
    } // end $listingTotalRow
  ?>
</div>