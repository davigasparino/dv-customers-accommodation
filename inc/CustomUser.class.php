<?php
/**
 * Class CustomUser
 */
class CustomUser {
    use CustomersUtils;

    /**
     * CustomUser constructor.
     */
    public function __construct( )
    {
        self::HooksAndFilters();
    }

    /**
     * Hooks And Filters
     */
    public function HooksAndFilters() : void
    {
        add_filter( 'theme_page_templates', array($this, 'HookTemplatesPageList'), 10, 4 );
        add_filter( 'page_template', array($this, 'CustomUsersPanelTemplate') );
        add_filter('script_loader_tag', array($this, 'AddAttrType') , 10, 3);
        add_action('wp_enqueue_scripts', array($this, 'CustomUserEnqueue'));
        add_action( 'init', array( $this, 'CustomUserAjaxAddRewriteRules' ), 10 );
        add_action( 'parse_request', array( $this, 'CustomUserActionRequest' ), 10, 1 );
        add_action( 'save_post', array( $this, 'ActionSaveCustomUserCPT' ), 10, 3 );
        add_action( 'fm_user', array($this, 'MetaboxCustomUser'));
        add_action( 'init', array($this, 'CustomersRewriteTags') );
    }

    /**
     * Add Metaboxes and field to CustomUsers custom post type
     *
     * @throws FM_Developer_Exception
     */
    public function MetaboxCustomUser () : void
    {
        $fmAddress = new Fieldmanager_Group(array(
            'name' => 'user_address',
            'label'          => 'Endereço',
            'label_macro'    => array('%s', 'address'),
            'sortable'       => true,
            'limit'          => 5,
            'collapsible'    => true,
            'collapsed'      => false,
            'add_more_label' => 'Adicionar conteúdo',
            'group_is_empty' => function( $values ) { return empty( $values['address'] ); },
            'children' => array(
                'country' => new Fieldmanager_TextField('País'),
                'state' => new Fieldmanager_TextField('Estado'),
                'city' => new Fieldmanager_TextField('Cidade'),
                'address' => new Fieldmanager_TextField('Endereço'),
                'address_number' => new Fieldmanager_TextField('N°'),
                'neighborhood' => new Fieldmanager_TextField( 'Bairro' ),
                'cep' => new Fieldmanager_TextField( 'cep' ),
            ),
        ));
        $fmAddress->add_user_form( ' ' );

        $fmPhones = new Fieldmanager_Group(array(
            'name' => 'user_phones',
            'label'          => 'Telefone',
            'label_macro'    => array('%s', 'number'),
            'sortable'       => true,
            'limit'          => 5,
            'collapsible'    => true,
            'collapsed'      => false,
            'add_more_label' => 'Adicionar conteúdo',
            'group_is_empty' => function( $values ) { return empty( $values['number'] ); },
            'children' => array(
                'ddi' => new Fieldmanager_TextField('DDI'),
                'ddd' => new Fieldmanager_TextField('DDD'),
                'number' => new Fieldmanager_TextField( 'Número' ),
                'principal' => new Fieldmanager_Checkbox('Telefone Pricipal')
            )
        ));
        $fmPhones->add_user_form( ' ' );

        $fmUser = new Fieldmanager_Group(array(
            'name' => 'user_fields',
            'label' => 'Dados Pessoais',
            'children' => array(
                'profile' => new Fieldmanager_Media('Imagem do perfil'),
                'cpf' => new Fieldmanager_TextField('cpf'),
                'rg' => new Fieldmanager_TextField('rg'),
            ),
        ));
        $fmUser->add_user_form( ' ' );

        $fmCustom = new Fieldmanager_Group(array(
            'name' => 'custom',
            'label' => 'Customizações',
            'children' => array(
                'favorite_items' => new Fieldmanager_TextField('Favoritos'),
            )
        ));
        $fmCustom->add_user_form( ' ' );
    }

    /**
     * Hook Templates Page List
     *
     * @param $post_templates
     * @param $wp_theme
     * @param $post
     * @param $post_type
     * @return mixed
     */
    function HookTemplatesPageList( $post_templates, $wp_theme, $post, $post_type ) {
        $post_templates['user-register.php'] = __('Cadastro de clientes');
        $post_templates['userpanel'] = __('Painel do Cliente');
        return $post_templates;
    }

    /**
     * Customers Rewrite Tags
     */
    public function CustomersRewriteTags() : void
    {
        add_rewrite_tag( '%panel%', '([^/]*)' );
        add_rewrite_tag( '%partner%', '([^/]*)' );
        add_rewrite_tag( '%action%', '([^/]*)' );
        add_rewrite_tag( '%postid%', '([^/]*)' );
        add_rewrite_rule(
            '^admin/([^/]*)/?([^/]*)/?([^/]*)/?([^/]*)/?([^/]*)/?$',
            'index.php?pagename=admin&panel=$matches[1]&partner=$matches[2]&action=$matches[3]&postid=$matches[4]',
            'top'
        );
    }

    /**
     * Customers Panel Template
     *
     * @param $page_template
     * @return string
     */
    function CustomUsersPanelTemplate( $page_template ){
        if ( get_page_template_slug() == 'user-register.php' ) {
            $page_template = CustomerPATH . 'templates/user-register.php';
        }
        if ( get_page_template_slug() == 'userpanel' ) {
            $page_template = CustomerPATH . 'templates/user-panel.php';
        }
        return $page_template;
    }

    /**
     * CustomUser Ajax Add Rewrite Rules
     */
    public function CustomUserAjaxAddRewriteRules() : void
    {
        add_rewrite_rule(
            '^custom-user-ajax/?$',
            'index.php',
            'top'
        );
    }

    /**
     * CustomUser Action Request
     *
     * @param $request
     * @return string|null
     */
    public function CustomUserActionRequest( $request )
    {
        if ( 'custom-user-ajax' === $request->request ) {

            switch ($_REQUEST['action']){
                case 'UploadProfileImage':
                    return self::UploadProfileImage();
                    break;

                case 'UpdateUserDatas':
                    return self::UpdateUserDatas();
                    break;

                case 'loginUser':
                    return self::loginUser();
                    break;

                case 'userLogout':
                    return self::UserLogout();
                    break;

                case 'updatePass':
                    return self::updatePass();
                    break;

                case 'FavoriteItem':
                    return self::FavoriteItem();
                    break;

                default;
                    break;
            }
            exit();
        }
    }

    /**
     * Action Save CustomUser CPT
     *
     * @param $post_ID
     * @param $post
     * @param $update
     */
    public function ActionSaveCustomUserCPT( $post_ID, $post, $update ) : void
    {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( is_admin() && function_exists('wpcom_vip_purge_edge_cache_for_url') ) {
            wpcom_vip_purge_edge_cache_for_url( site_url( 'custom-user-ajax' ) );
        }
    }

    /**
     * Add Attribute Type
     *
     * @param $tag
     * @param $handle
     * @param $src
     * @return string
     */
    public function AddAttrType($tag, $handle, $src) : string
    {
        if ( 'stablishments-cpt-scripts' !== $handle && 'CustomUsers-scripts' !== $handle && 'CustomUsers-user-scripts' !== $handle ) {
            return $tag;
        }
        $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
        return $tag;
    }

    public function CustomUserEnqueue( ) : void
    {
        wp_enqueue_script( 'CustomUsers-scripts', CustomerURL . 'assets/public/js/scripts.js', array(), false, true );
        wp_enqueue_script( 'CustomUsers-user-scripts', CustomerURL . 'assets/public/js/single.js', array(), false, true );

        $ajax_slug = 'CustomUser';
        $vars = [
            'url'           => site_url('custom-user-ajax'),
            'nounce'         => wp_create_nonce( $ajax_slug . "_nounce" ),
            'action'         => 'CustomUserActionRequest',
            'CustomUser_ajax'   => $ajax_slug,
        ];

        wp_localize_script('CustomUsers-scripts', $ajax_slug.'_js', $vars);
    }

}

