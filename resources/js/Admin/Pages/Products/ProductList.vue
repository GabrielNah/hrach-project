<template>
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title-box">
                    <h4 class="font-size-18">Products List</h4>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="mdi mdi-home-outline"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                        <li class="breadcrumb-item active">Products List</li>
                    </ol>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="float-right d-none d-md-block">
                    <div class="dropdown">
                        <router-link :to="{name:ADMIN_PRODUCT_ADD}" aria-expanded="false" aria-haspopup="true"
                                class="btn btn-primary dropdown-toggle waves-effect waves-light" data-toggle="dropdown" type="button">
                            <i class="mdi mdi-settings mr-2"></i> Add Product
                        </router-link>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Separated link</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div id="datatable_length" class="dataTables_length"><label>Show <select
                                            aria-controls="datatable" class="custom-select custom-select-sm form-control form-control-sm"
                                            name="datatable_length">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select> entries</label></div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div id="datatable_filter" class="dataTables_filter"><label>Search:<input
                                            aria-controls="datatable" class="form-control form-control-sm" placeholder=""
                                            type="search"></label></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="datatable"
                                               aria-describedby="datatable_info"
                                               class="table table-striped table-centered dt-responsive nowrap table-vertical dataTable no-footer dtr-inline"
                                               role="grid" style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                                            <thead>
                                            <tr role="row">
                                                <th aria-controls="datatable" aria-label="Image: activate to sort column descending" aria-sort="ascending"
                                                    class="sorting_asc" colspan="1" rowspan="1" style="width: 73px;"
                                                    tabindex="0">Image
                                                </th>
                                                <th aria-controls="datatable" aria-label="Product Name: activate to sort column ascending" class="sorting" colspan="1"
                                                    rowspan="1" style="width: 356px;"
                                                    tabindex="0">Product
                                                    Name
                                                </th>
                                                <th aria-controls="datatable" aria-label="Added Date: activate to sort column ascending" class="sorting" colspan="1"
                                                    rowspan="1" style="width: 120px;"
                                                    tabindex="0">Added
                                                    Date
                                                </th>
                                                <th aria-controls="datatable" aria-label="Amount: activate to sort column ascending" class="sorting" colspan="1"
                                                    rowspan="1" style="width: 87px;"
                                                    tabindex="0">Amount
                                                </th>
                                                <th aria-controls="datatable" aria-label="No. of Units: activate to sort column ascending" class="sorting" colspan="1"
                                                    rowspan="1" style="width: 122px;"
                                                    tabindex="0">No. of
                                                    Units
                                                </th>
                                                <th aria-controls="datatable" aria-label="Stock: activate to sort column ascending" class="sorting" colspan="1"
                                                    rowspan="1" style="width: 68px;"
                                                    tabindex="0">Stock
                                                </th>
                                                <th aria-controls="datatable" aria-label="Action: activate to sort column ascending" class="sorting" colspan="1"
                                                    rowspan="1" style="width: 75px;"
                                                    tabindex="0">Action
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>


                                            <tr class="odd" role="row">
                                                <td class="product-list-img sorting_1" tabindex="0">
                                                    <img alt="tbl"
                                                         class="img-fluid avatar-sm rounded" src="assets/images/products/1.jpg">
                                                </td>
                                                <td>
                                                    <h6 class="mt-0 mb-1">Gray belt watch</h6>
                                                    <p class="m-0 font-size-14">Sed ut perspiciatis unde omnis iste.</p>
                                                </td>
                                                <td>22/05/2017</td>
                                                <td>$521</td>
                                                <td>5841</td>
                                                <td>
                                                    <div class="progress" style="height: 5px;">
                                                        <div aria-valuemax="100" aria-valuemin="0"
                                                             aria-valuenow="25" class="progress-bar bg-danger" role="progressbar"
                                                             style="width: 25%;"></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <ul class="list-inline m-0">
                                                        <li class="list-inline-item">
                                                            <button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                                </svg>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr class="even" role="row">
                                                <td class="product-list-img sorting_1" tabindex="0">
                                                    <img alt="tbl"
                                                         class="img-fluid avatar-sm rounded" src="assets/images/products/2.jpg">
                                                </td>
                                                <td>
                                                    <h6 class="mt-0 mb-1">Riverston Glass Chair</h6>
                                                    <p class="m-0 font-size-14">natus error sit voluptatem
                                                        doloremque.</p>
                                                </td>
                                                <td>28/03/2017</td>
                                                <td>$210</td>
                                                <td>841</td>
                                                <td>
                                                    <div class="progress" style="height: 5px;">
                                                        <div aria-valuemax="100" aria-valuemin="0"
                                                             aria-valuenow="25" class="progress-bar bg-success" role="progressbar"
                                                             style="width: 85%;"></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a class="mr-3 text-primary" data-original-title="Edit"
                                                       data-placement="top" data-toggle="tooltip" href="javascript:void(0);"
                                                       title=""><i
                                                        class="mdi mdi-pencil font-size-18"></i></a>
                                                    <a class="text-danger" data-original-title="Delete"
                                                       data-placement="top" data-toggle="tooltip" href="javascript:void(0);"
                                                       title=""><i
                                                        class="mdi mdi-close font-size-18"></i></a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                        <div id="datatable_info" aria-live="polite" class="dataTables_info"
                                             role="status">Showing 1 to 10 of 16 entries
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        <div id="datatable_paginate" class="dataTables_paginate paging_simple_numbers">
                                            <ul class="pagination">
                                                <li id="datatable_previous"
                                                    class="paginate_button page-item previous disabled"><a aria-controls="datatable" class="page-link"
                                                                               data-dt-idx="0" href="#"
                                                                               tabindex="0">Previous</a></li>
                                                <li class="paginate_button page-item active"><a aria-controls="datatable"
                                                                                                class="page-link"
                                                                                                data-dt-idx="1"
                                                                                                href="#"
                                                                                                tabindex="0">1</a>
                                                </li>
                                                <li class="paginate_button page-item "><a aria-controls="datatable"
                                                                                          class="page-link"
                                                                                          data-dt-idx="2" href="#"
                                                                                          tabindex="0">2</a></li>
                                                <li id="datatable_next" class="paginate_button page-item next"><a
                                                    aria-controls="datatable" class="page-link" data-dt-idx="3" href="#"
                                                    tabindex="0">Next</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->


    </div>
</template>

<script>
import {ADMIN_PRODUCT_ADD} from "../../../router/Admin/adminRoutes";

export default {
    name: "ProductList",
    setup(){
        return{
            ADMIN_PRODUCT_ADD
        }
    }
}
</script>

<style scoped>

</style>
