<?php
global $routesPlugin;

$routesPlugin['liveSearch']= 'kiosk/view/manager/liveSearch.php';
//$routesPlugin['testJavascript']= 'kiosk/view/manager/testJavascript.php';

	// tài khoản
$routesPlugin['login']= 'kiosk/view/manager/login.php';
$routesPlugin['dashboard']= 'kiosk/view/manager/dashboard.php';
$routesPlugin['logout']= 'kiosk/view/manager/logout.php';
$routesPlugin['infoStaff']= 'kiosk/view/manager/infoStaff.php';
$routesPlugin['forgetPassStaff']= 'kiosk/view/manager/forgetPassStaff.php';
$routesPlugin['forgetPassStaffProcess']= 'kiosk/view/manager/forgetPassStaffProcess.php';
$routesPlugin['viewStaff']= 'kiosk/view/manager/viewStaff.php';
    // sản phẩm
$routesPlugin['listProduct']= 'kiosk/view/manager/listProduct.php';
$routesPlugin['addProduct']= 'kiosk/view/manager/addProduct.php';
$routesPlugin['infoProduct']= 'kiosk/view/manager/infoProduct.php';
$routesPlugin['deleteProduct']= 'kiosk/view/manager/deleteProduct.php';
$routesPlugin['updateProduct']= 'kiosk/view/manager/updateProduct.php';
    // điểm đặt
$routesPlugin['listPlace']= 'kiosk/view/manager/listPlace.php';
$routesPlugin['addPlace']= 'kiosk/view/manager/addPlace.php';
$routesPlugin['infoPlace']= 'kiosk/view/manager/infoPlace.php';
$routesPlugin['deletePlace']= 'kiosk/view/manager/deletePlace.php';
    // danh sách máy
$routesPlugin['listMachine']= 'kiosk/view/manager/listMachine.php';
// danh sách máy dạng bản đồ
$routesPlugin['infoMachine']= 'kiosk/view/manager/infoMachine.php';
$routesPlugin['mapDevice']= 'kiosk/view/manager/mapDevice.php';
$routesPlugin['addMachine']= 'kiosk/view/manager/addMachine.php';
$routesPlugin['deleteMachine']= 'kiosk/view/manager/deleteMachine.php';
$routesPlugin['structureMachine']= 'kiosk/view/manager/structureMachine.php';
$routesPlugin['addFloorMachine']= 'kiosk/view/manager/addFloorMachine.php';
$routesPlugin['infoTrench']= 'kiosk/view/manager/infoTrench.php';
$routesPlugin['deleteTrench']= 'kiosk/view/manager/deleteTrench.php';
$routesPlugin['addTrench']= 'kiosk/view/manager/addTrench.php';
$routesPlugin['deleteFloor']= 'kiosk/view/manager/deleteFloor.php';
$routesPlugin['settingFloorMachine']= 'kiosk/view/manager/settingFloorMachine.php';
$routesPlugin['sendConfigToKiosk']= 'kiosk/view/manager/sendConfigToKiosk.php';
    // danh sách máy lỗi
$routesPlugin['listMachineError']= 'kiosk/view/manager/listMachineError.php';
$routesPlugin['infoMachineError']= 'kiosk/view/manager/infoMachineError.php';
// danh sách lỗi
$routesPlugin['addErrorMachine']= 'kiosk/view/manager/addErrorMachine.php';
$routesPlugin['listErrorMachine']= 'kiosk/view/manager/listErrorMachine.php';
$routesPlugin['deleteErrorMachine']= 'kiosk/view/manager/deleteErrorMachine.php';
$routesPlugin['infoErrorMachine']= 'kiosk/view/manager/infoErrorMachine.php';
$routesPlugin['infoStaffCom']= 'kiosk/view/manager/infoStaffCom.php';

    // lịch sử giao dịch
$routesPlugin['listTransfer']= 'kiosk/view/manager/listTransfer.php';
$routesPlugin['listCollection']= 'kiosk/view/manager/listCollection.php';
$routesPlugin['viewTransfer']= 'kiosk/view/manager/viewTransfer.php';
$routesPlugin['viewCollection']= 'kiosk/view/manager/viewCollection.php';
$routesPlugin['infoCollection']= 'kiosk/view/manager/infoCollection.php';

// danh sách giao dịch bằng mã Coupon
$routesPlugin['transactionWhitCoupon']= 'kiosk/view/manager/transactionWhitCoupon.php';
// danh sách giao dịch theo tiền mặt
$routesPlugin['transactionWhitCash']= 'kiosk/view/manager/transactionWhitCash.php';
// danh sách giao dịch theo QR
$routesPlugin['transactionWhitQRViettin']= 'kiosk/view/manager/transactionWhitQRViettin.php';
// xóa 1 lịch sử giao dịch bởi nv phân quyền
$routesPlugin['deleteTransactionByEmployees']= 'kiosk/view/manager/deleteTransactionByEmployees.php';
// xem các máy không có giao dịch trong khoảng thời gian nào đó.
$routesPlugin['machinesTransfer']= 'kiosk/view/manager/machinesTransfer.php';
// kiểm tra dữ liệu giao dịch và đồng bộ.
$routesPlugin['syncTransfer']= 'kiosk/view/manager/syncTransfer.php';
// upload dữ liệu từ file excel cuả máy kiosk lên.
$routesPlugin['syncTransferUpload']= 'kiosk/view/manager/syncTransferUpload.php';
//chi tiết đối soát.
$routesPlugin['syncDetails']= 'kiosk/view/manager/syncDetails.php';
//test tủng các thứ
//$routesPlugin['testEverything']= 'kiosk/view/manager/testEverything.php';

    // mã tặng quà
$routesPlugin['listCoupon']= 'kiosk/view/manager/listCoupon.php';
$routesPlugin['addCoupon']= 'kiosk/view/manager/addCoupon.php';
$routesPlugin['deleteCoupon']= 'kiosk/view/manager/deleteCoupon.php';
$routesPlugin['infoCoupon']= 'kiosk/view/manager/infoCoupon.php';
$routesPlugin['uploadCoupon']= 'kiosk/view/manager/uploadCoupon.php';

    // cài đặt công ty
$routesPlugin['listCompany']= 'kiosk/view/manager/listCompany.php';
$routesPlugin['addCompany']= 'kiosk/view/manager/addCompany.php';
$routesPlugin['deleteCompany']= 'kiosk/view/manager/deleteCompany.php';
$routesPlugin['viewCompany']= 'kiosk/view/manager/viewCompany.php';


$routesPlugin['listBranch']= 'kiosk/view/manager/listBranch.php';
$routesPlugin['addBranch']= 'kiosk/view/manager/addBranch.php';
$routesPlugin['deleteBranch']= 'kiosk/view/manager/deleteBranch.php';
$routesPlugin['infoBranch']= 'kiosk/view/manager/infoBranch.php';

$routesPlugin['groupPermission']= 'kiosk/view/manager/groupPermission.php';
$routesPlugin['addPermission']= 'kiosk/view/manager/addPermission.php';
$routesPlugin['deletePermission']= 'kiosk/view/manager/deletePermission.php';
$routesPlugin['permissionStaff']= 'kiosk/view/manager/permissionStaff.php';
$routesPlugin['infoPermission']= 'kiosk/view/manager/infoPermission.php';
$routesPlugin['listStaffCompany']= 'kiosk/view/manager/listStaffCompany.php';
$routesPlugin['addStaffCompany']= 'kiosk/view/manager/addStaffCompany.php'; //thêm nhân viên theo công ty.
$routesPlugin['deleteStaffCompany']= 'kiosk/view/manager/deleteStaffCompany.php';
$routesPlugin['infoStaffCompany']= 'kiosk/view/manager/infoStaffCompany.php';
$routesPlugin['addNewStaff']= 'kiosk/view/manager/addNewStaff.php'; //thêm nhân viên.


    // API
$routesPlugin['getInfoMachineAPI']= 'kiosk/getInfoMachineAPI.php';
$routesPlugin['saveTransferAPI']= 'kiosk/saveTransferAPI.php';
$routesPlugin['updateStatusMachineAPI']= 'kiosk/updateStatusMachineAPI.php';
$routesPlugin['saveCollectionAPI']= 'kiosk/saveCollectionAPI.php';
$routesPlugin['updateConfigMachineAPI']= 'kiosk/updateConfigMachineAPI.php';
$routesPlugin['checkCouponAPI']= 'kiosk/checkCouponAPI.php';
$routesPlugin['priceSaleAPI']= 'kiosk/priceSaleAPI.php';

// Vietinbank
$routesPlugin['getQRVietinbankAPI']= 'kiosk/getQRVietinbankAPI.php';
$routesPlugin['callBackVietinbankAPI']= 'kiosk/callBackVietinbankAPI.php';
$routesPlugin['testSignatureAPI']= 'kiosk/testSignatureAPI.php';

    // báo cáo
// doanh thu theo ngay cua  diem dat
$routesPlugin['lisstReportRevenueByPlaceOnDay']= 'kiosk/view/manager/lisstReportRevenueByPlaceOnDay.php';
//báo cáo theo ncc
$routesPlugin['listReportBySuppliers']= 'kiosk/view/manager/listReportBySuppliers.php';
//bbaos cáo  ncc theo sản phẩm
$routesPlugin['listReportBySuppliersOrderProduct']= 'kiosk/view/manager/listReportBySuppliersOrderProduct.php';
// báo cáo theo điểm đặt
$routesPlugin['listReportTotalSalesByPlace']= 'kiosk/view/manager/listReportTotalSalesByPlace.php';
// báo cáo chi tiết điểm đặt theo máy
$routesPlugin['listRevenueByPlaceOrderMachine']= 'kiosk/view/manager/listRevenueByPlaceOrderMachine.php';
// xem chi tiết lịch sử doanh thu  máy
$routesPlugin['viewDetailHistoryMachineRevenue']= 'kiosk/view/manager/viewDetailHistoryMachineRevenue.php';
// báo cáo điểm đặt theo sản phẩm
$routesPlugin['listRevenueByPlaceOrderProduct']= 'kiosk/view/manager/listRevenueByPlaceOrderProduct.php';
// báo cáo điểm đặt theo thời gian
$routesPlugin['listRevenueByPlaceOrderTime']= 'kiosk/view/manager/listRevenueByPlaceOrderTime.php';
$routesPlugin['listReportByChannel']= 'kiosk/view/manager/listReportByChannel.php';

$routesPlugin['listReportTotalSalesByMachine']= 'kiosk/view/manager/listReportTotalSalesByMachine.php';
//tổng doanh thu theo tiền mặt
$routesPlugin['listRevenueByCash']= 'kiosk/view/manager/listRevenueByCash.php';
// tổng hợp doanh thu qua thẻ
$routesPlugin['listRevenueByCard']= 'kiosk/view/manager/listRevenueByCard.php';
// báo cáo phân phối máy theo tỉnh:
$routesPlugin['listReportMachineByProvince']= 'kiosk/view/manager/listReportMachineByProvince.php';
// báo cáo phân phối máy theo điểm đặt

$routesPlugin['listReportMachineByPlace']= 'kiosk/view/manager/listReportMachineByPlace.php';
// báo cáo doanh thu theo chi nhánh
$routesPlugin['listRevenueByBranch']= 'kiosk/view/manager/listRevenueByBranch.php';
// báo cáo doanh thu theo nhà cung cấp nhớm bởi nhà cung cấp
$routesPlugin['listRevenueByBranchOrderSupplier']= 'kiosk/view/manager/listRevenueByBranchOrderSupplier.php';
// danh sách toàn bộ  nhân viên
$routesPlugin['listAllStaff']= 'kiosk/view/manager/listAllStaff.php';
$routesPlugin['informationStaff']= 'kiosk/view/manager/informationStaff.php';
$routesPlugin['deleteStaffByGovernance']= 'kiosk/view/manager/deleteStaffByGovernance.php';


// load place with ajax
$routesPlugin['load']= 'kiosk/view/manager/load.php';
//load error with ajax
$routesPlugin['loadError']= 'kiosk/view/manager/loadError.php';
// check number
$routesPlugin['checkNumber']= 'kiosk/view/manager/checkNumber.php';

// thống kê giao dịch
$routesPlugin['staticTransactionsVietinbank']= 'kiosk/staticTransactionsVietinbank.php';
$routesPlugin['changeError']= 'kiosk/view/manager/changeError.php';

$routesPlugin['testAPI']= 'kiosk/testAPI.php';

// Tra cứu sản phẩm theo máy - function listProductByMachine trong ProductController
$routesPlugin['listProductByMachine']= 'kiosk/view/manager/listProductByMachine.php';
$routesPlugin['testEverything']= 'kiosk/view/manager/testEverything.php';
// quản lý giá
$routesPlugin['priceManage']= 'kiosk/view/manager/priceManage.php';
$routesPlugin['priceTransport']= 'kiosk/view/manager/priceTransport.php';
$routesPlugin['deleteTransport']= 'kiosk/view/manager/deleteTransport.php';
$routesPlugin['editTransport']= 'kiosk/view/manager/editTransport.php';
$routesPlugin['deleteNewProduct']= 'kiosk/view/manager/deleteNewProduct.php';
$routesPlugin['editManage']= 'kiosk/view/manager/editManage.php';
$routesPlugin['viewManage']= 'kiosk/view/manager/viewManage.php';
$routesPlugin['priceProduct']= 'kiosk/view/manager/priceProduct.php';
$routesPlugin['updateStatusPrice']= 'kiosk/view/manager/updateStatusPrice.php';
$routesPlugin['deletePrice']= 'kiosk/view/manager/deletePrice.php';
$routesPlugin['priceProductOld']= 'kiosk/view/manager/priceProductOld.php';
$routesPlugin['reportByMachine']= 'kiosk/view/manager/reportByMachine.php';
$routesPlugin['reportRevenue2Year']= 'kiosk/view/manager/reportRevenue2Year.php';

// hóa đơn.
$routesPlugin['viewBill']='kiosk/view/manager/bill/viewBill.php';

// tesst
$routesPlugin['ajaxtProduct']='kiosk/view/manager/ajaxtProduct.php';
// floorMachine
$routesPlugin['synchMachine']='kiosk/view/manager/synchMachine.php';
// danh sách ctkm giảm giá theo đơn hàng
$routesPlugin['listSale']='kiosk/view/manager/listSale.php';
$routesPlugin['addSale']='kiosk/view/manager/addSale.php';
$routesPlugin['infoSale']='kiosk/view/manager/infoSale.php';
$routesPlugin['editSale']='kiosk/view/manager/editSale.php';
$routesPlugin['deleteSale']='kiosk/view/manager/deleteSale.php';

$routesPlugin['ajaxMachine']='kiosk/view/manager/ajaxMachine.php';



?>
