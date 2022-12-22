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

  namespace ClicShopping\Apps\Report\StatsEmailValidation\Sites\ClicShoppingAdmin\Pages\Home\Actions\StatsEmailValisation;

  use ClicShopping\OM\Registry;

  class Reset extends \ClicShopping\OM\PagesActionsAbstract
  {
    public function execute()
    {
      $CLICSHOPPING_StatsEmailValidation = Registry::get('StatsEmailValidation');

      $Qupdate = $CLICSHOPPING_StatsEmailValidation->db->prepare('update :table_customers
                                                            set customers_email_validation = :customers_email_validation
                                                          ');
      $Qupdate->bindInt(':customers_email_validation', 0);

      $Qupdate->execute();
    }
  }