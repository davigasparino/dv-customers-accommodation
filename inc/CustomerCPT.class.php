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
            add_action('wp_head', array($this, 'CustomerEnqueueStyles'));
            add_action( 'init', array( $this, 'CustomerAjaxAddRewriteRules' ), 10 );
            add_action( 'parse_request', array( $this, 'CustomerActionRequest' ), 10, 1 );
            add_action( 'save_post', array( $this, 'ActionSaveCustomerCPT' ), 10, 3 );
            add_filter( 'single_template', array($this, 'CustomerSingleTemplate'));
            add_action('dv_blank_navbar_coll', function(){include_once(CustomerPATH . '/templates/login.php');});
            add_action('wp_footer', function(){ include(CustomerPATH . '/templates/parts/form_login.php'); });
            add_action('init', function(){ session_start(); });
            add_filter('script_loader_tag', array($this, 'AddAttrType') , 10, 3);
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
            if ( 'customers-cpt-scripts' !== $handle && 'single-scripts' !== $handle ) {
                return $tag;
            }
            $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
            return $tag;
        }

        public function CustomerEnqueue( ) : void
        {
            global $post;
            wp_enqueue_script( 'customers-cpt-scripts', CustomerURL . '/assets/public/js/scripts.js', array(), false, true );

            $ajax_slug = 'Customer';
            $vars = [
                'url'           => site_url('customer-ajax'),
                'nounce'         => wp_create_nonce( $ajax_slug . "_nounce" ),
                'action'         => 'CustomerActionRequest',
                'Customer_ajax'   => $ajax_slug,
            ];

            if(isset($post) && $this->cpt === $post->post_type || get_page_template_slug() == 'customer-register.php'){
                wp_enqueue_script( 'single-scripts', CustomerURL . '/assets/public/js/single.js', array(), false, true );
                wp_localize_script('single-scripts', $ajax_slug.'_js', $vars);
            }

            wp_localize_script('customers-cpt-scripts', $ajax_slug.'_js', $vars);
        }

        /**
         * Customer Enqueue Styles
         */
        public function CustomerEnqueueStyles() : void
        {
            wp_enqueue_style('customers-cpt-css', CustomerURL . '/assets/public/css/style.css');
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

            $fmPass = new Fieldmanager_Group(array(
                'name' => 'user_pass',
                'children' => array(
                    'pass' => new Fieldmanager_Password('Senha'),
                ),
            ));
            $fmPass->add_meta_box('Senha', $this->cpt, 'normal', 'high');

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
            if ( get_page_template_slug() == 'customer-register.php' ) {
                $page_template = CustomerPATH . '/templates/customer-register.php';
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
            $post_templates['customer-register.php'] = __('Cadastro de clientes');
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

                    case 'loginUser':
                        return self::loginUser();
                        break;

                    case 'userLogout':
                        return self::UserLogout();
                        break;

                    case 'updatePass':
                        return self::updatePass();
                        break;

                    default;
                        break;
                }
                exit();
            }

        }

        /**
         * Update Pass
         *
         * @return string
         */
        public function updatePass() : string
        {
            $nonce = isset($_REQUEST['nounce']) ? sanitize_text_field($_REQUEST['nounce']) : '';
            if ( ! wp_verify_nonce( $nonce, 'Customer_nounce' ) ) {
                return wp_send_json(new WP_Error('wperro', 'Nounce Inválido'));
            }

            $oldPassword = (isset($_REQUEST['oldPassword'])) ? sanitize_text_field($_REQUEST['oldPassword']) : null;
            $newPassword = (isset($_REQUEST['newPassword'])) ? sanitize_text_field($_REQUEST['newPassword']) : null;
            $confirmNewPassword = (isset($_REQUEST['confirmNewPassword'])) ? sanitize_text_field($_REQUEST['confirmNewPassword']) : null;
            $userID = (isset($_REQUEST['userPassword'])) ? sanitize_text_field($_REQUEST['userPassword']) : null;

            if(empty($newPassword) || is_null($newPassword) || $newPassword !== $confirmNewPassword){
                return wp_send_json(array(
                    'message' => 'Senhas não conferem',
                    'class' => 'alert,alert-danger'
                ));
            }

            if(strlen($newPassword) < 8){
                return wp_send_json(array(
                    'message' => 'Senha precisa conter mais que 8 caracteres',
                    'class' => 'alert,alert-danger'
                ));
            }

            $pass = get_post_meta($userID, 'user_pass');
            if(isset($pass)){
                $pass = array_shift($pass)['pass'];
            }

            if($pass !== $oldPassword){
                return wp_send_json(array(
                    'message' => 'Senha incorreta',
                    'class' => 'alert,alert-danger'
                ));
            }

            update_post_meta($userID, 'user_pass', array(
                'pass' => $newPassword
            ));

            return wp_send_json(array(
                'message' => 'Senha atualizada com sucesso',
                'class' => 'alert,alert-success'
            ));
        }

        /**
         * Update User Datas
         *
         * @param null $action
         * @return string
         */
        public function UpdateUserDatas($action = null) : string
        {
            $nonce = isset($_REQUEST['nounce']) ? sanitize_text_field($_REQUEST['nounce']) : '';
            if ( ! wp_verify_nonce( $nonce, 'Customer_nounce' ) ) {
                return wp_send_json(new WP_Error('wperro', 'Nounce Inválido'));
            }

            $postID = (isset($_REQUEST['userid'])) ? sanitize_text_field($_REQUEST['userid']) : null;

            $name = (isset($_REQUEST['user_name'])) ?  sanitize_text_field($_REQUEST['user_name']) : null;
            if(!$name){
                return wp_send_json(array(
                    'message' => 'O campo Nome é obrigatório',
                    'class' => 'alert,alert-danger'
                ));
            }

            $lastname = (isset($_REQUEST['user_lastname'])) ? sanitize_text_field($_REQUEST['user_lastname']) : null;
            if(!$lastname){
                return wp_send_json(array(
                    'message' => 'O campo Nome é obrigatório',
                    'class' => 'alert,alert-danger'
                ));
            }

            $email = (isset($_REQUEST['user_email'])) ? sanitize_text_field($_REQUEST['user_email']) : null;
            if(!$email){
                return wp_send_json(array(
                    'message' => 'O campo e-mail é obrigatório',
                    'class' => 'alert,alert-danger'
                ));
            }

            if(isset($pass)){
                $pass = (isset($_REQUEST['user_pass'])) ? sanitize_text_field($_REQUEST['user_pass']) : null;
                $confirm_pass = (isset($_REQUEST['confirm_user_pass'])) ? sanitize_text_field($_REQUEST['confirm_user_pass']) : null;
                if(isset($pass) && strlen($pass) < 1 ){
                    return wp_send_json(array(
                        'message' => 'O campo senha é obrigatório',
                        'class' => 'alert,alert-danger'
                    ));
                }else if(isset($pass) && $pass !== $confirm_pass){
                    return wp_send_json(array(
                        'message' => 'Senhas não conferem',
                        'class' => 'alert,alert-danger'
                    ));
                }

                if(strlen($pass) < 8){
                    return wp_send_json(array(
                        'message' => 'Senha precisa ter pelo menos 8 caracteres',
                        'class' => 'alert,alert-danger'
                    ));
                }
            }

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

            foreach ($addressArgs as $allItems){
                foreach ($allItems as $item => $item_value){
                    if(empty($item_value)){
                        return wp_send_json(array(
                            'message' => 'O campo '.$item.' é obrigatório.',
                            'class' => 'alert,alert-danger'
                        ));
                    }
                }
            }

            $countPhones = (isset($_REQUEST['countPhones'])) ?  sanitize_text_field($_REQUEST['countPhones']) : 0;
            $phonesArgs = array();
            for ($i = 0; $i < $countPhones; $i++){
                array_push($phonesArgs, array(
                    'ddi' => (isset($_REQUEST['user_phones_ddi_'.$i])) ? sanitize_text_field($_REQUEST['user_phones_ddi_'.$i]) : '',
                    'ddd' => (isset($_REQUEST['user_phones_ddd_'.$i])) ? sanitize_text_field($_REQUEST['user_phones_ddd_'.$i]) : '',
                    'number' => (isset($_REQUEST['user_phones_number_'.$i])) ? sanitize_text_field($_REQUEST['user_phones_number_'.$i]) : '',
                ));
            }

            foreach ($phonesArgs as $allItems){
                foreach ($allItems as $item => $item_value){
                    if(empty($item_value)){
                        return wp_send_json(array(
                            'message' => 'O campo '.$item.' é obrigatório.',
                            'class' => 'alert,alert-danger'
                        ));
                    }
                }
            }

            $newUser = false;
            if($postID){
                wp_update_post( array(
                    'ID'         => $postID,
                    'post_title' => $email
                ) );
            }else{
                if(!self::userExists($email)){
                    $postID = wp_insert_post(array(
                        'post_type' => $this->cpt,
                        'post_title' => $email,
                        'post_content' => $name,
                        'post_status' => 'publish'
                    ));
                    if($postID){
                        $newUser = true;
                    }
                }else{
                    return wp_send_json(array(
                        'message' => 'Já existe um usuário com este e-mail cadastrado',
                        'class' => 'alert,alert-warning'
                    ));
                }

            }

            update_post_meta( $postID, 'user_fields', $args );
            update_post_meta( $postID, 'user_address', $addressArgs );
            update_post_meta( $postID, 'user_phones', $phonesArgs );
            if(isset($pass)){
                update_post_meta( $postID, 'user_pass', array(
                    'pass' => $pass
                ));
            }

            if($newUser){
                self::loginUser(array(
                    'user' => $email,
                    'pass' => $pass
                ), true);
            }


            return wp_send_json(array(
                'message' => 'Usuário atualizado com sucesso!',
                'class' => 'alert,alert-success',
                'id' => $postID
            ));
        }


        /**
         * Upload Profile Image
         *
         * @return string
         */
        public function UploadProfileImage() : string
        {
            $nonce = isset($_REQUEST['nounce']) ? sanitize_text_field($_REQUEST['nounce']) : '';
            if ( ! wp_verify_nonce( $nonce, 'Customer_nounce' ) ) {
                return wp_send_json(new WP_Error('wperro', 'Nounce Inválido'));
            }

            $postID = (isset($_REQUEST['postID'])) ? sanitize_text_field($_REQUEST['postID']) : null;

            if(!$postID){
                return wp_send_json(array(
                    'message' => 'Campo email não pode ser vazio',
                    'image' => null,
                    'class' => 'alert,alert-danger',
                    'id' => null
                ));
            }

            require_once (ABSPATH . 'wp-admin/includes/image.php');
            require_once (ABSPATH . 'wp-admin/includes/file.php');
            require_once (ABSPATH . 'wp-admin/includes/media.php');

            $imgID = media_handle_upload('photo', $postID);

            set_post_thumbnail($postID,$imgID);

            return wp_send_json(array(
                'message' => 'Upload efetuado com sucesso',
                'image' => get_the_post_thumbnail_url($postID),
                'class' => 'alert,alert-success',
                'id' => $postID
            ));
        }

        /**
         * loginUser
         *
         * @param array $args
         * @param null $escape_nonce
         * @return string|null
         */
        public function loginUser($args = array(), $escape_nonce = null) : string | null
        {
            $nonce = isset($_REQUEST['nounce']) ? sanitize_text_field($_REQUEST['nounce']) : '';
            if (!$escape_nonce && !wp_verify_nonce( $nonce, 'Customer_nounce' ) ) {
                return wp_send_json(new WP_Error('Erro', 'Nounce Inválido'));
            }

            $user = (isset($_REQUEST['userLogin'])) ? sanitize_text_field($_REQUEST['userLogin']) : null;
            $pass = (isset($_REQUEST['userPass'])) ? sanitize_text_field($_REQUEST['userPass']) : null;

            if(isset($args['user'], $args['pass'])){
                $user = $args['user'];
                $pass = $args['pass'];
            }

            if(empty($user) || empty($pass)){
                return wp_send_json(array(
                    'message' => 'Campos obrigatórios',
                    'class' => 'alert,alert-danger'
                ));
            }

            $userID = self::userExists($user);
            if(!$userID){
                return wp_send_json(array(
                    'message' => 'Exte e-mail já consta em nosso sistema',
                    'class' => 'alert,alert-danger'
                ));
            }

            $pass = self::checkPassword($userID, $pass);
            if(!$pass){
                return wp_send_json(array(
                    'message' => 'Dados inválidos',
                    'class' => 'alert,alert-danger'
                ));
            }

            $name = array_shift(get_post_meta($userID, 'user_fields'));

            session_start();
            session_regenerate_id();
            $_SESSION['customer_loggedin'] = TRUE;
            $_SESSION['customer_name'] = $name['name'];
            $_SESSION['customer_id'] = $userID;

            return wp_send_json(array(
                'message' => 'Saudações ' . $_SESSION['customer_name'] . '!',
                'url' => get_permalink($userID),
                'status' => 'ok',
                'class' => 'alert,alert-success'
            ));
        }

        /**
         * Check user exists
         *
         * @param $user
         * @return bool|int
         */
        private function userExists($user) : int | bool
        {
            if ( ! function_exists( 'post_exists' ) ) {
                require_once( ABSPATH . 'wp-admin/includes/post.php' );
            }

            return post_exists($user, '', '', $this->cpt);
        }

        /**
         * Check Password
         *
         * @param $userID
         * @param $pass
         * @return bool
         */
        private function checkPassword($userID, $pass) : bool
        {
            $postmeta = array_shift(get_post_meta((int) $userID, 'user_pass'));

            if(isset($postmeta, $postmeta['pass']) && $postmeta['pass'] === $pass){
                return true;
            }

            return false;
        }

        /**
         * Logout
         */
        private function UserLogout()
        {
            session_start();
            session_destroy();
            return wp_send_json(array(
                'message' => 'Logout successfully!'
            ));
        }

    }

