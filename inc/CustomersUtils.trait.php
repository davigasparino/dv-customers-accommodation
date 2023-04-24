<?php
trait CustomersUtils{
    public function __construct()
    {
    }

    public static function getTitle($type = 'customer', $slug = 'dashboard')
    {
        $adminLinks = self::getMenuItems();
        ?>
        <h3 class="mb-3">
            <span class="material-symbols-outlined me-2"><?php echo esc_html($adminLinks[$type][$slug]['icon']); ?></span>
            <?php echo esc_html($adminLinks[$type][$slug]['name']); ?>
        </h3>
    <?php
    }

    public static function getMenuItems($key = null)
    {
        $menus = array(
            'customer' => array(
                'dashboard' => array(
                    'name' => 'Principal',
                    'icon' => 'dashboard',
                ),
                'dados-pessoais' => array(
                    'name' => 'Dados Pessoais',
                    'icon' => 'badge',
                ),
                'modo-anfitriao' => array(
                    'name' => 'Modo Anfitrião',
                    'icon' => 'real_estate_agent',
                ),
                'favoritos' => array(
                    'name' => 'Favoritos',
                    'icon' => 'heart_check',
                ),
                'reservas' => array(
                    'name' => 'Reservas',
                    'icon' => 'calendar_month',
                ),
                'financeiro' => array(
                    'name' => 'Financeiro',
                    'icon' => 'credit_card',
                ),
                'help' => array(
                    'name' => 'Preciso de ajuda',
                    'icon' => 'contact_support',
                ),
                'update-pass' => array(
                    'name' => 'Trocar senha',
                    'icon' => 'lock_reset',
                ),
                'logout' => array(
                    'name' => 'Sair',
                    'icon' => 'exit_to_app',
                    'id' => 'userLogout'
                ),
            ),
            'partner' => array(
                'dashboard-anfitriao' => array(
                    'icon' => 'bar_chart_4_bars',
                    'name' => 'Resumo'
                ),
                'establishments' => array(
                    'icon' => 'home_work',
                    'name' => 'Estabelecimentos'
                ),
                'locations' => array(
                    'icon' => 'real_estate_agent',
                    'name' => 'Locações'
                ),
            )

        );

        if($key){
            return $menus[$key];
        }

        return $menus;
    }
}
