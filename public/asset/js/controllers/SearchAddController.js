app.controller('SearchAddController', function($scope, $http) { 
  
    // ====For Check Box column Filters ===
    $scope.on_item_description      =   true;
    $scope.on_brand                 =   true;
    $scope.on_batch                 =   true;
    $scope.on_unit_packing_size     =   true;
    $scope.on_quantity              =   true; 
    $scope.on_owner_one             =   true; 
    $scope.on_storage_room          =   true; 
    $scope.on_house_type            =   true; 
    $scope.on_date_of_expiry        =   true; 
    $scope.on_iqc_status            =   true; 
    $scope.on_used_for_td           =   true; 

   
    // === Route Lists ===
    var material_products           =   $('#get-material-products').val();
    var edit_material_products      =   $('#edit-material-products').val();
    var delete_material_products    =   $('#delete-material-products').val();



    // ==== Get Data form DB ====
    $scope.get_material_products =  function () {
        $http({
            method: 'get', 
            url: material_products,  
        }).then(function(response) {
            $scope.material_products = response.data.data;
            $scope.material_products.links.shift();
            $scope.material_products.links.pop();
        }, function(response) {
            Message('danger', response.data.message);
        });
    }
    $scope.get_material_products();

    // ====== Edit Data DB ====
    $scope.edit_material_product = function (id) {
        var route =  edit_material_products +'/'+ id
        window.location.replace(route);
    }

    // ====== Delete Data DB ====
    $scope.delete_material_product = function (id) {
       var route = delete_material_products +"/"+id
        swal({
            text: "Are you sure want to Delete?",
            icon: "warning",
            buttons: {
                cancel: {
                    text: "Cancel",
                    value: null,
                    visible: true,
                    className: "btn-light rounded-pill btn",
                    closeModal: true,
                },
                confirm: {
                    text: "Yes! Delete",
                    value: true,
                    visible: true,
                    className: "btn btn-danger rounded-pill",
                    closeModal: true
                }
            }, 
        }).then((isConfirm) => {
            if(isConfirm) {
                $http({
                    method: 'POST', 
                    url: route, 
                }).then(function(response) {
                    $scope.data = response.data; 
                    $scope.get_material_products();
                    Message('success', response.data.message); 
                }, function(response) {
                    $scope.data = response.data || 'Request failed';
                });
            } 
        });
    }

    //  ===== Pagination & Filters ====
    $scope.getPage = function (link) { 
        if($scope.material_products.current_page == link.label) {
            return false
        }
        $http({
            method: 'get', 
            url: link.url,  
        }).then(function(response) {
            $scope.material_products = response.data.data; 
            $scope.material_products.links.shift();
            $scope.material_products.links.pop();
        }, function(response) {
            Message('danger', response.data.message);
        });  
    } 
    $scope.next_Prev_page = function (params) {
        $http({
            method: 'get', 
            url: params,  
        }).then(function(response) {
            $scope.material_products = response.data.data; 
            $scope.material_products.links.shift();
            $scope.material_products.links.pop();
        }, function(response) {
            Message('danger', response.data.message);
        });  
    }  
    $scope.sort_by = function (name, type) {
        $http({
            method: 'post', 
            url: material_products,
            data : {
                sort_by: {
                    col_name :  name ,
                    order_type :  type ,
                }
            }
        }).then(function(response) {
            $scope.material_products = response.data.data;
            $scope.material_products.links.shift();
            $scope.material_products.links.pop();
        }, function(response) {
            Message('danger', response.data.message);
        });
    }
    $scope.search_barcode_number = function () {
        $http({
            method: 'post', 
            url: material_products,
            data : {
                filters: $scope.barcode_number
            }
        }).then(function(response) {
            $scope.material_products = response.data.data;
            $scope.material_products.links.shift();
            $scope.material_products.links.pop();
        }, function(response) {
            Message('danger', response.data.message);
        });
    } 
    $scope.bulk_search = function () {
        if($scope.item_description == undefined && $scope.brand == undefined && $scope.owner == undefined && $scope.dept == undefined && $scope.storage_area == undefined && $scope.date_in == undefined) {
            return false
        }
       let date_in = moment($scope.date_in).format('YYYY-MM-DD');
        
        $http({
            method: 'post', 
            url: material_products,
            data : {
                bulk_search: {
                    item_description : $scope.item_description == undefined ? '' : $scope.item_description,
                    brand : $scope.brand == undefined ? '' : $scope.brand,
                    owner : $scope.owner == undefined ? '' : $scope.owner,
                    dept : $scope.dept == undefined ? '' : $scope.dept,
                    storage_area : $scope.storage_area == undefined ? '' : $scope.storage_area,
                    date_in : $scope.date_in == undefined ? '' : date_in,
                }
            }
        }).then(function(response) {
            $scope.material_products = response.data.data;
            $scope.material_products.links.shift();
            $scope.material_products.links.pop();
        }, function(response) {
            Message('danger', response.data.message);
        });
    }
    $scope.reset_bulk_search = function () {
        $scope.get_material_products();
        $scope.item_description = ''
        $scope.brand = ''
        $scope.owner = ''
        $scope.dept = ''
        $scope.storage_area = ''
        $scope.date_in = ''
    } 
    $scope.view_material_product = function (row) {
        $('#View_Material_Product_Details').modal('show'); 
        $scope.view_material_product_data  = [
            {name: "Category Selection", item:row.category_selection == 'in_house' ? 'In-house Product' : 'Material'},
            {name: 'Item description' , item : row.item_description},
            {name: 'In-house Product Logsheet ID#' , item : row.in_house_product_logsheet_id},
            {name: 'EUC material' , item : row.euc_material},
            {name: 'Brand' , item : row.brand},
            {name: 'Supplier' , item : row.supplier},
            {name: 'Unit Packing size' , item : row.unit_packing_size},
            {name: 'Statutory body' , item : row.statutory_body},
            {name: 'Owner 1' , item : row.owner_one},
            {name: 'Owner 2 (SE/PL/FM)' , item : row.owner_two},
            {name: 'Remarks' , item : row.remarks},
            {name: 'Alert Threshold Qty for new material/product description' , item : row.alert_threshold_qty_for_new},
            {name: 'Alert before expiry (in terms of weeks) for new material/product description' , item : row.alert_before_expiry},
            {name: 'Access' , item : row.access},
        ]
    }

    // Advanced Search Fitters
 

});