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

  namespace ClicShopping\Apps\Report\StatsEmailValidation\Sites\ClicShoppingAdmin\Pages\Home;

  use ClicShopping\OM\Registry;

  use ClicShopping\Apps\Report\StatsEmailValidation\StatsEmailValidation;

  class Home extends \ClicShopping\OM\PagesAbstract
  {
    public mixed $app;

    protected function init()
    {
      $CLICSHOPPING_StatsEmailValidation = new StatsEmailValidation();
      Registry::set('StatsEmailValidation', $CLICSHOPPING_StatsEmailValidation);

      $CLICSHOPPING_StatsEmailValidation = Registry::get('StatsEmailValidation');

      $this->app = $CLICSHOPPING_StatsEmailValidation;

      $this->app->loadDefinitions('Sites/ClicShoppingAdmin/main');
    }
  }
