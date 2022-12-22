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

  namespace ClicShopping\Apps\Report\StatsEmailValidation\Sites\ClicShoppingAdmin\Pages\Home\Actions;

  use ClicShopping\OM\Registry;

  class StatsEmailValidation extends \ClicShopping\OM\PagesActionsAbstract
  {
    public function execute()
    {
      $CLICSHOPPING_StatsEmailValidation = Registry::get('StatsEmailValidation');

      $this->page->setFile('stats_email_validation.php');

      $CLICSHOPPING_StatsEmailValidation->loadDefinitions('Sites/ClicShoppingAdmin/main');
    }
  }