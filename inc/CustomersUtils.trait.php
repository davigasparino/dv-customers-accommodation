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
     * get Tags Establishments
     *
     * @param $type
     * @return string[][]
     */
    public function getTagEstablishments($type) : array
    {
        $taxonomiesItems = array(
            'partner_add' => array(
                array(
                    'item' => 'wifi',
                    'icon' => 'wifi',
                ),
                array(
                    'item' => 'cozinha',
                    'icon' => 'flatware',
                ),
                array(
                    'item' => 'tv',
                    'icon' => 'tv_gen',
                ),
                array(
                    'item' => 'estacionamento',
                    'icon' => 'garage_home',
                ),
                array(
                    'item' => 'máquina de lavar',
                    'icon' => 'dishwasher_gen',
                ),
                array(
                    'item' => 'ar-condicionado',
                    'icon' => 'ac_unit',
                ),
                array(
                    'item' => 'espaço para home office',
                    'icon' => 'business_center',
                ),
                array(
                    'item' => 'piscina',
                    'icon' => 'pool',
                ),
                array(
                    'item' => 'jacuzzi',
                    'icon' => 'hot_tub',
                ),
                array(
                    'item' => 'ofurô',
                    'icon' => 'bath_private',
                ),
                array(
                    'item' => 'banheira',
                    'icon' => 'bathtub',
                ),
                array(
                    'item' => 'churrasqueira',
                    'icon' => 'outdoor_grill',
                ),
                array(
                    'item' => 'fogueira',
                    'icon' => 'local_fire_department',
                ),
                array(
                    'item' => 'lareira interna',
                    'icon' => 'fireplace',
                ),
                array(
                    'item' => 'piano',
                    'icon' => 'piano',
                ),
                array(
                    'item' => 'chuveiro externo',
                    'icon' => 'shower',
                ),
                array(
                    'item' => 'extintor de incendio',
                    'icon' => 'fire_extinguisher',
                ),
                array(
                    'item' => 'detector de fumança',
                    'icon' => 'detector_smoke',
                ),
                array(
                    'item' => 'kit de primeiros socorros',
                    'icon' => 'medical_services',
                )
            ),
            'partner_type' => array(
                array(
                    'item' => 'Apartamento',
                    'icon' => 'apartament',
                ),
                array(
                    'item' => 'Casa',
                    'icon' => 'house',
                ),
                array(
                    'item' => 'Casa de Campo',
                    'icon' => 'cottage',
                ),
                array(
                    'item' => 'Casa de Praia',
                    'icon' => 'beach_access',
                ),
                array(
                    'item' => 'Cabana',
                    'icon' => 'bungalow',
                ),
                array(
                    'item' => 'Chalé',
                    'icon' => 'chalet',
                ),
                array(
                    'item' => 'Chácara',
                    'icon' => 'gite',
                ),
                array(
                    'item' => 'Fazenda',
                    'icon' => 'agriculture',
                ),
                array(
                    'item' => 'Pousada',
                    'icon' => 'night_shelter',
                ),
                array(
                    'item' => 'quarto privativo',
                    'icon' => 'bed'
                )
            )
        );

        return $taxonomiesItems[$type];
    }

    public function getIconsSelect()
    {
        return array(
            'search','home','menu','close','settings','done','expand_more','check_circle','favorite','add','delete','arrow_back','star','chevron_right','logout','arrow_forward_ios','add_circle','cancel','arrow_back_ios','arrow_forward','arrow_drop_down','more_vert','check','check_box','toggle_on','grade','open_in_new','check_box_outline_blank','refresh','login','chevron_left','expand_less','radio_button_unchecked','more_horiz','apps','arrow_right_alt','radio_button_checked','download','remove','toggle_off','bolt','arrow_upward','filter_list','delete_forever','autorenew','key','arrow_downward','sort','sync','block','add_box','arrow_back_ios_new','restart_alt','menu_open','shopping_cart_checkout','expand_circle_down','backspace','arrow_circle_right','undo','done_all','arrow_right','do_not_disturb_on','open_in_full','double_arrow','manage_search','sync_alt','zoom_in','done_outline','drag_indicator','fullscreen','keyboard_double_arrow_right','star_half','settings_accessibility','ios_share','arrow_drop_up','reply','exit_to_app','unfold_more','library_add','cached','select_check_box','terminal','change_circle','disabled_by_default',
        );
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
