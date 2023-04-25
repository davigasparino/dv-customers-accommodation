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
            ),
            'stablishments' => array(
                'list' => array(
                    'icon' => 'format_list_bulleted',
                    'name' => 'Todos'
                ),
                'form' => array(
                    'icon' => 'domain_add',
                    'name' => 'Novo'
                ),
            )

        );

        if($key){
            return $menus[$key];
        }

        return $menus;
    }

    /**
     * Register Custom Post Type
     *
     * @param array $attr
     * @param array $custom_args
     * @param array $custom_labels
     */
    public static function CustomPostType($attr = array(), $custom_args = array(), $custom_labels = array()) : void
    {
        $singular = $attr['singular'];
        $plural = $attr['plural'];

        $labels = array(
            'name' => __( $plural ),
            'singular_name' => __( $singular ),
            'menu_name'           => __( $plural ),
            'parent_item_colon'   => __( $singular . ' Ascendente' ),
            'all_items'           => __( 'Todos os ' .$plural ),
            'view_item'           => __( 'Ver ' . $singular ),
            'add_new_item'        => __( 'Adicionar ' . $singular ),
            'add_new'             => __( 'Adicionar novo' ),
            'edit_item'           => __( 'Editar ' . $singular ),
            'update_item'         => __( 'Atualizar ' . $singular ),
            'search_items'        => __( 'Buscar ' . $singular ),
            'not_found'           => __( $singular . ' não encontrado' ),
            'not_found_in_trash'  => __( $singular . ' não encontrado no Lixo' ),
        );

        $labels = array_merge($labels, $custom_labels);

        $args = array(
            'has_archive' => false,
            'show_in_rest' => false,
            'label'               => __( $plural ),
            'description'         => __( $plural ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'thumbnail' ),
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'can_export'          => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
        );

        $args = array_merge($args, $custom_args);

        register_post_type($attr['cpt'], $args,);
    }

    /**
     * Register Custom Taxonomy
     *
     * @param array $args
     */
    function CreateTaxonomy($args = array()) : void
    {
        if(!isset($args, $args['label'], $args['taxonomy'])){
            return;
        }

        $configs = array(
            'hierarchical' => true,
            'label' => $args['label'],
            'query_var' => true,
        );

        if( isset($args['rewrite']) && is_array($args['rewrite'])){
            $configs['rewrite'] = array(
                'slug' => $args['slug'],
                'with_front' => true,
            );
        }

        register_taxonomy(
            $args['taxonomy'],
            $args['cpt'],
            $configs
        );
    }

}
