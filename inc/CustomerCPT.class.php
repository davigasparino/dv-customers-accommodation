<?php
    /**
     * Class CustomerCPT
     */
    class CustomerCPT {

        private string $cpt;

        /**
         * CustomerCPT constructor.
         * @param string|null $customer
         */
        public function __construct( string $customer = null )
        {
            $this->cpt = ($customer) ? $customer : 'customers';
        }

        /**
         * Init Customer Object
         */
        public function Init() : void
        {
            self::HooksAndFilters();
        }

        /**
         * Hooks And Filters
         */
        public function HooksAndFilters() : void
        {
            add_action('init', array($this, 'CustomPostType'));
            add_action('fm_post_'.$this->cpt, array($this, 'MetaboxCustomerCPT'));
            add_filter( 'theme_page_templates', array($this, 'HookTemplatesPageList'), 10, 4 );
            add_filter( 'page_template', array($this, 'CustomersPanelTemplate') );
            add_action('wp_enqueue_scripts', array($this, 'CustomerEnqueue'));
            add_action( 'init', array( $this, 'CustomerAjaxAddRewriteRules' ), 10 );
            add_action( 'parse_request', array( $this, 'CustomerActionRequest' ), 10, 1 );
            add_action( 'save_post', array( $this, 'ActionSaveCustomerCPT' ), 10, 3 );
            add_filter( 'single_template', array($this, 'CustomerSingleTemplate'));
        }

        public function CustomerEnqueue( ) : void
        {
            global $post;
            wp_enqueue_script( 'customers-cpt-scripts', CustomerURL . '/assets/public/js/scripts.js', array(), false, true );

            if($this->cpt === $post->post_type){
                wp_enqueue_script( 'single-scripts', CustomerURL . '/assets/public/js/single.js', array(), false, true );
                $ajax_slug = 'Customer';
                $vars = [
                    'url'           => site_url('customer-ajax'),
                    'nounce'         => wp_create_nonce( $ajax_slug . "_nounce" ),
                    'action'         => 'CustomerActionRequest',
                    'Customer_ajax'   => $ajax_slug,
                ];
                wp_localize_script('single-scripts', $ajax_slug.'_js', $vars);
                wp_localize_script('customers-cpt-scripts', $ajax_slug.'_js', $vars);
            }
        }

        /**
         * Register Custom Post Type Customers
         */
        public function CustomPostType() : void
        {
            $singular = 'Cliente';
            $plural = 'Clientes';

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

            $args = array(
                'has_archive' => false,
                'show_in_rest' => false,
                'label'               => __( $plural ),
                'description'         => __( $plural . ' Business' ),
                'labels'              => $labels,
                'supports'            => array( 'title', 'thumbnail' ),
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
                'menu_icon'           => 'dashicons-groups',
            );

            register_post_type($this->cpt, $args,);
        }

        /**
         * Add Metaboxes and field to Customers custom post type
         *
         * @throws FM_Developer_Exception
         */
        public function MetaboxCustomerCPT () : void
        {
            $fmUser = new Fieldmanager_Group(array(
                'name' => 'user_fields',
                'children' => array(
                    'name' => new Fieldmanager_TextField('Nome'),
                    'lastname' => new Fieldmanager_TextField('sobrenome'),
                    'email' => new Fieldmanager_TextField('E-mail'),
                ),
            ));
            $fmUser->add_meta_box('Dados de Cadastro', $this->cpt, 'normal', 'high');

            $fmAddress = new Fieldmanager_Group(array(
                'name' => 'user_address',
                'label'          => ' ',
                'label_macro'    => array('%s', 'address'),
                'sortable'       => true,
                'limit'          => 5,
                'collapsible'    => true,
                'collapsed'      => true,
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
            $fmAddress->add_meta_box('Endereços', $this->cpt, 'normal', 'high');

            $fmPhones = new Fieldmanager_Group(array(
                'name' => 'user_phones',
                'label'          => ' ',
                'label_macro'    => array('%s', 'number'),
                'sortable'       => true,
                'limit'          => 5,
                'collapsible'    => true,
                'collapsed'      => true,
                'add_more_label' => 'Adicionar conteúdo',
                'group_is_empty' => function( $values ) { return empty( $values['number'] ); },
                'children' => array(
                    'ddi' => new Fieldmanager_TextField('DDI'),
                    'ddd' => new Fieldmanager_TextField('DDD'),
                    'number' => new Fieldmanager_TextField( 'Número' ),
                    'principal' => new Fieldmanager_Checkbox('Telefone Pricipal')
                )
            ));
            $fmPhones->add_meta_box('Telefones', $this->cpt, 'normal', 'high');

        }

        /**
         * Customers Panel Template
         *
         * @param $page_template
         * @return string
         */
        function CustomersPanelTemplate( $page_template ){
            if ( get_page_template_slug() == 'customer-panel.php' ) {
                $page_template = CustomerPATH . '/templates/customer-login.php';
            }
            return $page_template;
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
            $post_templates['customer-login.php'] = __('Login');
            return $post_templates;
        }

        /**
         * Action Save Customer CPT
         *
         * @param $post_ID
         * @param $post
         * @param $update
         */
        public function ActionSaveCustomerCPT( $post_ID, $post, $update ) : void
        {
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
            }

            if ( is_admin() && $this->cpt === $post->post_type && function_exists('wpcom_vip_purge_edge_cache_for_url') ) {
                wpcom_vip_purge_edge_cache_for_url( site_url( 'customer-ajax' ) );
            }
        }

        /**
         * Customer Single Template
         *
         * @param $single_template
         * @return string
         */
        function CustomerSingleTemplate($single_template) {
            global $post;

            if ($post->post_type == $this->cpt ) {
                $single_template = CustomerPATH . '/templates/single-template.php';
            }
            return $single_template;
        }

        /**
         * Customer Ajax Add Rewrite Rules
         */
        public function CustomerAjaxAddRewriteRules() : void
        {
            add_rewrite_rule(
                '^customer-ajax/?$',
                'index.php',
                'top'
            );
        }

        /**
         * Customer Action Request
         *
         * @param $request
         * @return string|null
         */
        public function CustomerActionRequest( $request )
        {
            if ( 'customer-ajax' === $request->request ) {
                switch ($_REQUEST['action']){
                    case 'UploadProfileImage':
                        return self::UploadProfileImage();
                        break;

                    case 'UpdateUserDatas':
                        return self::UpdateUserDatas();
                        break;

                    default;
                        break;
                }
                exit();
            }

        }

        public function UpdateUserDatas()
        {
            $nonce = isset($_REQUEST['nounce']) ? sanitize_text_field($_REQUEST['nounce']) : '';
            if ( ! wp_verify_nonce( $nonce, 'Customer_nounce' ) ) {
                return wp_send_json(new WP_Error('wperro', 'Nounce Inválido'));
            }

            $postID = (isset($_REQUEST['userid'])) ? sanitize_text_field($_REQUEST['userid']) : null;
            $pass = (isset($_REQUEST['user_password'])) ? sanitize_text_field($_REQUEST['user_password']) : null;
            $email = (isset($_REQUEST['user_email'])) ? sanitize_text_field($_REQUEST['user_email']) : null;
            $name = (isset($_REQUEST['user_name'])) ?  sanitize_text_field($_REQUEST['user_name']) : null;
            $lastname = (isset($_REQUEST['user_lastname'])) ? sanitize_text_field($_REQUEST['user_lastname']) : null;


            $args = array(
                'name' => $name,
                'lastname' => $lastname,
                'email' => $email
            );

            $countAddress = (isset($_REQUEST['countAddress'])) ?  sanitize_text_field($_REQUEST['countAddress']) : 0;
            $addressArgs = array();
            for ($i = 0; $i < $countAddress; $i++){
                array_push($addressArgs, array(
                    'country' => (isset($_REQUEST['address_'.$i.'_country'])) ? sanitize_text_field($_REQUEST['address_'.$i.'_country']) : '',
                    'state' => (isset($_REQUEST['address_'.$i.'_state'])) ? sanitize_text_field($_REQUEST['address_'.$i.'_state']) : '',
                    'city' => (isset($_REQUEST['address_'.$i.'_city'])) ? sanitize_text_field($_REQUEST['address_'.$i.'_city']) : '',
                    'address' => (isset($_REQUEST['address_'.$i.'_address'])) ? sanitize_text_field($_REQUEST['address_'.$i.'_address']) : '',
                    'address_number' => (isset($_REQUEST['address_'.$i.'_address_number'])) ? sanitize_text_field($_REQUEST['address_'.$i.'_address_number']) : '',
                    'neighborhood' => (isset($_REQUEST['address_'.$i.'_neighborhood'])) ? sanitize_text_field($_REQUEST['address_'.$i.'_neighborhood']) : '',
                    'cep' => (isset($_REQUEST['address_'.$i.'_cep'])) ? sanitize_text_field($_REQUEST['address_'.$i.'_cep']) : '',
                ));
            }

            $countPhones = (isset($_REQUEST['countPhones'])) ?  sanitize_text_field($_REQUEST['countPhones']) : 0;
            $phonesArgs = array();
            for ($i = 0; $i < $countPhones; $i++){
                array_push($phonesArgs, array(
                    'ddi' => (isset($_REQUEST['user_phones_ddi_'.$i])) ? sanitize_text_field($_REQUEST['user_phones_ddi_'.$i]) : '',
                    'ddd' => (isset($_REQUEST['user_phones_ddd_'.$i])) ? sanitize_text_field($_REQUEST['user_phones_ddd_'.$i]) : '',
                    'number' => (isset($_REQUEST['user_phones_number_'.$i])) ? sanitize_text_field($_REQUEST['user_phones_number_'.$i]) : '',
                    'principal' => (isset($_REQUEST['user_phones_principal_'.$i])) ? sanitize_text_field($_REQUEST['user_phones_principal_'.$i]) : null,
                ));
            }

            update_post_meta( $postID, 'user_fields', $args );
            update_post_meta( $postID, 'user_address', $addressArgs );
            update_post_meta( $postID, 'user_phones', $phonesArgs );

            exit();
        }

        public function UploadProfileImage() {
            $nonce = isset($_REQUEST['nounce']) ? sanitize_text_field($_REQUEST['nounce']) : '';
            if ( ! wp_verify_nonce( $nonce, 'Customer_nounce' ) ) {
                return wp_send_json(new WP_Error('wperro', 'Nounce Inválido'));
            }

            require_once (ABSPATH . 'wp-admin/includes/image.php');
            require_once (ABSPATH . 'wp-admin/includes/file.php');
            require_once (ABSPATH . 'wp-admin/includes/media.php');

            $postID = (isset($_REQUEST['postID'])) ? sanitize_text_field($_REQUEST['postID']) : null;
            $imgID = media_handle_upload('photo', $postID);

            set_post_thumbnail($postID,$imgID);

            return wp_send_json(get_the_post_thumbnail_url($postID));
            exit();
        }

    }

