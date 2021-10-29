<!DOCTYPE html>
<html lang="en">
@include('common.header')
<body class="sb-nav-fixed">
<div id="layoutSidenav_content">
    <main>
        @include('common.success_error_msg')
        <div class="container-fluid">
            <div class="card mb-4">
                <div class="table-responsive">
                    <div class="card-header">
                        <form id="order_data_filter_form" class="list-filter-form">
                            <table style="width:100%">
                                <tr>
                                    <td> <i>Welcome <?php echo getSession('user_data')['name'].'('.getSession('user_data')['email'].')'; ?></i></td>
                                    <td> <button type="button" class="btn btn-success" onclick="openPostStatusModal()">Post Your Status</button></td>
                                    <td> <button style="float:right" type="button" class="btn btn-secondary" onclick="logOut()">Logout</button></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <table class="display table table-striped table-bordered full-width-table datatable-content" colspans="0" id="mainPagesDataTable" width="100%">

                    </table>
                </div>
            </div>
        </div>
    </main>
    @include('modals.common_modal')
    @include('modals.post_status_modal')
    @include('modals.user_status_modal')
    @include('common.footer')
</div>
</div>
@include('common.footer_javascripts')
</body>
</html>
