<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\Category;
use App\Country;
use App\Document;
use App\Vendor;
use App\User;
use App\Http\Controllers\Controller;
use App\Mail\VendorProfileComplete;
use App\Mail\EmailInformation;
use App\Mail\VendorChangeProfile;
use App\Mail\VendorFeedbackProfile;
use App\Mail\VendorRemindReviewers;
use App\Mail\VendorRemindVendor;
use App\Mail\VendorReviewProfile;
use App\Notification;
use App\Service;
use App\State;
use App\VendorBankAccounts;
use App\VendorNotification;
use App\VendorService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use Response;
use Illuminate\Support\Facades\Mail;
use Permission;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(User::hasPermissions("Vendor Index")){
            $vendors = Vendor::where('is_active', true)->orderBy('id', 'asc')->get();
            $categories = Category::orderBy('name', 'asc')->get();
            return view('vendors.index',compact('vendors', 'categories'));
        }else{
            return redirect('/');
        }
    }

    public function deleteVendor(Request $request){
        try{
            DB::beginTransaction();
            $vendor = Vendor::findorFail((int)$request->vendorId);
            $vendor->is_active = false;
            $vendor->update();
            DB::commit();
            return ['deleteVendor' => true, 'message' => __('Vendor successfully removed')];
        } catch(\Exception $e){
            DB::rollback();
            return ['deleteVendor' => false, 'message' => __('Could not be removed'), $e];
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(User::hasPermissions("Vendor Create")){
            $categories = Category::orderBy('name', 'asc')->get();
           return view('vendors.create', compact('categories'));
        }else{
            return redirect('/');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vendor = new Vendor();
        $vendor->name = $request->name;
        $vendor->legal_name = $request->legal;
        $vendor->contact_name = $request->contact;
        $vendor->status = '0';
        $vendor->color_status = '#e57373';
        $vendor->save();
        if( $request->vendorServices != null ){
            foreach($request->vendorServices as $key){
                $vendorService = new VendorService();
                $vendorService->vendor_id = $vendor->id;
                $vendorService->service_id = (int)$key;
                $vendorService->updated_by = auth()->user()->id;
                $vendorService->save();
            }
        }
        return redirect()->route('vendor.index')->withStatus(__('Vendor successfully created.'));
    }

    public function edit2($id){
        if(User::hasPermissions("Vendor Edit")){
            $vendor= Vendor::findorFail($id);
            $services = Service::groupBy('category')->orderBy('category', 'asc')->get();
            return view('vendors.edit2', compact('vendor','services'));
        }else{
            return redirect('/');
        }

    }

    public function update2(Request $request)
    {
        try{
            DB::beginTransaction();
            $vendor = Vendor::findorFail((int)$request->vendorId);
            $vendor->name = $request->name;
            $vendor->legal_name = $request->legal;
            $vendor->contact_name = $request->contact;
            $vendor->update();
            $flagServices = false;
            if($request->vendorServices != null){
                $flagServices = true;
            }
            foreach($vendor->vendorServices as $item){
                $stateRemoval = false;
                if($flagServices){
                    foreach($request->vendorServices as $key){
                        if($item->service_id == (int)$key){
                            $stateRemoval = true;
                        }
                    }
                }
                if($stateRemoval == false){
                    VendorService::destroy($item->id);
                }

            }
            if($flagServices){
                foreach($request->vendorServices as $key){
                    if($request->vendorServices != null){
                        $stateAdd = false;
                        foreach($vendor->vendorServices as $item){
                            if($item->service_id == (int)$key){
                                $stateAdd = true;
                            }
                        }
                        if($stateAdd == false){
                            $vendorService = new VendorService();
                            $vendorService->vendor_id = (int)$request->vendorId;
                            $vendorService->service_id = (int)$key;
                            $vendorService->updated_by = auth()->user()->id;
                            $vendorService->save();
                        }
                    }

                }
            }
            DB::commit();
            return ['updateVendor' => true];
        } catch(\Exception $e){
            DB::rollback();
            return ['updateVendor' => false,'message' => __('Could not update the provider'), $e];
        }
    }

    public function updateDone(Request $request){
        return redirect()->route('vendor.index')->withStatus(__('Successfully edited Vendor.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->user()->role->name == 'Vendor'){
            $vendor = Vendor::where('user_id', auth()->user()->id)->get()->first();
        }else{
            $vendor= Vendor::findorFail($id);
        }
        $tableClass = 'd-none';
        $messageClass = '';
        $btnSendClass = '';
        $btnSendMsj = __('Profile completed');
        $query = "SELECT COUNT(va.vendor_id) AS 'totalActive' FROM vendor_bank_accounts AS va, bank_accounts AS ba WHERE va.bank_account_id = ba.id AND ba.is_status_complete = 1 AND ba.is_status_active = 1 AND va.vendor_id = ".$id;
        $query1 = "SELECT COUNT(va.vendor_id) AS 'total' FROM vendor_bank_accounts AS va, bank_accounts AS ba WHERE va.bank_account_id = ba.id AND ba.is_status_active = 1 AND va.vendor_id = ".$id;
        $query2 = "SELECT COUNT(vs.vendor_id) AS total FROM vendor_services AS vs, vendors AS v WHERE vs.vendor_id = v.id AND v.id = ".$id;
        $accountActives =DB::select( DB::raw($query));
        $servicesT =DB::select( DB::raw($query2));
        $accountsVendorNumber = DB::select( DB::raw($query1));
        if($accountsVendorNumber[0]->total > 0){
            $tableClass = '';
            $messageClass = 'd-none';
        }
        if( ($vendor->country_id != '142') && ($vendor->country_id != '') ){
            $vendor->key_rfc = '-----';
            $vendor->path_cover_rfc = '-----';
            $vendor->path_32d = '-----';
        }
        $vendor->update();

        $btnColor ='btn-primary';

        if(
             ($vendor->name == '') || ($vendor->street == '') || ($vendor->path_address_proof == '') ||
             ($vendor->legal_name == '') ||($vendor->contact_name == '') ||
             ($vendor->inner_number	 == '') || ($vendor->outer_number == '') || ($vendor->suburb == '') ||
             ($vendor->delegation == '') || ($vendor->postal_code == '') || ($vendor->country_id == '') ||
             ($vendor->state_id == '') || ($vendor->city == '') || ($accountActives[0]->totalActive == 0) ||
             ($servicesT[0]->total == 0) ||
             ($vendor->key_rfc == '') || ($vendor->path_cover_rfc == '') ||
             ($vendor->mobile == '')  ||
             ($vendor->path_official_identification == '') || ($vendor->path_32d == '')

        ){
            $btnSendClass = 'disabled';
            $btnColor ='';
            $btnSendMsj = __('Fill out the form in order for submit your profile');
        }
        if( ($vendor->country_id != '142') && ($vendor->country_id != '') ){
            $vendor->key_rfc = null;
            $vendor->path_cover_rfc = null;
            $vendor->path_32d = null;
        }
        $vendor->update();
        $clabeClass = 'd-none';
        $btnAddAccount = '';
        $btnAddAccountTitle = '';
        if($vendor->country_id == 142){
            $clabeClass = '';
        }
        $divBank = '';
        if($vendor->country_id == null){
            $divBank = 'd-none';
            $btnAddAccount = 'd-none';
            $btnAddAccountTitle = __('Select a country to activate this option');
        }
        $swiftClass = 'd-none';
        if($vendor->country_id != 142 && $vendor->country_id != null){
            $swiftClass = '';
        }

        $countries = Country::orderBy('id', 'asc')->get();
        $states = State::where('country_id', $vendor->country_id)->get();
        $categories = Category::orderBy('name', 'asc')->get();
        $feedbacks = VendorNotification::where('vendor_id', $vendor->id)->where('is_review', 1)->where('motive', '!=', null)->get();
        $btnClassEnable = 'disabled';
        $inputClassEnable = 'readonly';
        $divUpdate = false;
        $notifyApprove = Notification::where('action', 'Agreed Vendor')->where('targeted_user', auth()->user()->id)->where('is_status_activated', true)->get()->first();
        if($notifyApprove != null){
            $notifyApprove->is_status_activated = false;
            $notifyApprove->update();
        }
        $notifysOpen = VendorNotification::where('vendor_id', $vendor->id)->where('revision_number', $vendor->revision_number)->where('motive', '!=', null)->get();
        if($vendor->status == '2'){
            return view('vendors.editRead',compact('notifysOpen','divUpdate','inputClassEnable','btnClassEnable','categories', 'btnColor','divBank', 'states','swiftClass','vendor','btnAddAccountTitle', 'btnAddAccount','tableClass', 'messageClass', 'btnSendClass', 'btnSendMsj', 'clabeClass', 'countries'));
        }else{
            return view('vendors.edit',compact('notifysOpen','feedbacks','categories', 'btnColor','divBank', 'states','swiftClass','vendor','btnAddAccountTitle', 'btnAddAccount','tableClass', 'messageClass', 'btnSendClass', 'btnSendMsj', 'clabeClass', 'countries'));
        }
    }



    public function readVendor($id)
    {
        if( (User::hasPermissions("Vendor Watch")) || (User::hasPermissions("Vendor Edit")) || (User::hasPermissions("Vendor Watch")) ){
            $vendor= Vendor::findorFail($id);
            $tableClass = 'd-none';
            $messageClass = '';
            $btnSendClass = '';
            $btnSendMsj = __('Profile completed');
            $query = "SELECT COUNT(va.vendor_id) AS 'totalActive' FROM vendor_bank_accounts AS va, bank_accounts AS ba WHERE va.bank_account_id = ba.id AND ba.is_status_complete = 1 AND ba.is_status_active = 1 AND va.vendor_id = ".$id;
            $query1 = "SELECT COUNT(va.vendor_id) AS 'total' FROM vendor_bank_accounts AS va, bank_accounts AS ba WHERE va.bank_account_id = ba.id AND ba.is_status_active = 1 AND va.vendor_id = ".$id;
            $query2 = "SELECT COUNT(vs.vendor_id) AS total FROM vendor_services AS vs, vendors AS v WHERE vs.vendor_id = v.id AND v.id = ".$id;
            $accountActives =DB::select( DB::raw($query));
            $servicesT =DB::select( DB::raw($query2));
            $accountsVendorNumber = DB::select( DB::raw($query1));
            if($accountsVendorNumber[0]->total > 0){
                $tableClass = '';
                $messageClass = 'd-none';
            }
            if( ($vendor->country_id != '142') && ($vendor->country_id != '') ){
                $vendor->key_rfc = '-----';
                $vendor->path_cover_rfc = '-----';
                $vendor->path_32d = '-----';
            }
            $vendor->update();

            $btnColor ='btn-primary';

            if(
                ($vendor->name == '') || ($vendor->street == '') || ($vendor->path_address_proof == '') ||
                ($vendor->legal_name == '') ||($vendor->contact_name == '') ||
                ($vendor->inner_number	 == '') || ($vendor->outer_number == '') || ($vendor->suburb == '') ||
                ($vendor->delegation == '') || ($vendor->postal_code == '') || ($vendor->country_id == '') ||
                ($vendor->state_id == '') || ($vendor->city == '') || ($accountActives[0]->totalActive == 0) ||
                ($servicesT[0]->total == 0) ||
                ($vendor->key_rfc == '') || ($vendor->path_cover_rfc == '') ||
                ($vendor->mobile == '')  ||
                ($vendor->path_official_identification == '') || ($vendor->path_32d == '')

            ){
                $btnSendClass = 'disabled';
                $btnColor ='';
                $btnSendMsj = __('Fill out the form in order for submit your profile');
            }
            if( ($vendor->country_id != '142') && ($vendor->country_id != '') ){
                $vendor->key_rfc = null;
                $vendor->path_cover_rfc = null;
                $vendor->path_32d = null;
            }
            $vendor->update();
            $clabeClass = 'd-none';
            $btnAddAccount = '';
            $btnAddAccountTitle = '';
            if($vendor->country_id == 142){
                $clabeClass = '';
            }
            $divBank = '';
            if($vendor->country_id == null){
                $divBank = 'd-none';
                $btnAddAccount = 'd-none';
                $btnAddAccountTitle = __('Select a country to activate this option');
            }
            $swiftClass = 'd-none';
            if($vendor->country_id != 142 && $vendor->country_id != null){
                $swiftClass = '';
            }

            $countries = Country::orderBy('id', 'asc')->get();
            $states = State::where('country_id', $vendor->country_id)->get();
            $categories = Category::orderBy('name', 'asc')->get();
            $btnClassEnable = 'disabled';
            $inputClassEnable = 'readonly';
            $divUpdate = false;
            if( User::hasPermissions("Vendor Edit") ){
                $btnClassEnable = '';
                $divUpdate = true;
                $inputClassEnable = '';
            }
            if($vendor->status == '2'){
                $btnClassEnable = 'disabled';
                $divUpdate = false;
                $inputClassEnable = 'readonly';
            }

            $notifysOpen = VendorNotification::where('vendor_id', $vendor->id)->where('revision_number', $vendor->revision_number)->where('motive', '!=', null)->get();

            return view('vendors.editRead',compact('notifysOpen','inputClassEnable','btnClassEnable', 'divUpdate','categories', 'btnColor','divBank', 'states','swiftClass','vendor','btnAddAccountTitle', 'btnAddAccount','tableClass', 'messageClass', 'btnSendClass', 'btnSendMsj', 'clabeClass', 'countries'));
        }else{
            return redirect('/');
        }
    }





    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function updateJs(Request $request)
    {
        try{
            $vendor= Vendor::findorFail((int)$request->vendorId);

            $servicesInfo = explode(",", $request->vendorServices);
            foreach($vendor->vendorServices as $item){
                $stateRemoval = false;
                foreach($servicesInfo as $key){
                    if($item->service_id == (int)$key){
                        $stateRemoval = true;
                    }
                }
                if($stateRemoval == false){
                    VendorService::destroy($item->id);
                }

            }

            foreach($servicesInfo as $key){
                if($request->vendorServices != null){
                    $stateAdd = false;
                    foreach($vendor->vendorServices as $item){
                        if($item->service_id == (int)$key){
                            $stateAdd = true;
                        }
                    }
                    if($stateAdd == false){
                        $vendorService = new VendorService();
                        $vendorService->vendor_id = (int)$request->vendorId;
                        $vendorService->service_id = (int)$key;
                        $vendorService->updated_by = auth()->user()->id;
                        $vendorService->save();
                    }
                }

            }

            $vendor->name = $request->name;
            $vendor->legal_name = $request->legal_name;
            $vendor->contact_name = $request->contact_name;
            $vendor->mobile = $request->mobile;
            $vendor->phone = $request->phone;
            if($request->path_address_proof	 != ''){
                if($vendor->path_address_proof  != null){
                    $document = new Document();
                    $document->table_name = 'vendors';
                    $document->record_id = $vendor->id;
                    $document->path_document = $vendor->path_address_proof;
                    $document->record_column_name = 'path_address_proof';
                    $document->save();

                }
                $path = \Storage::disk('s3')->put('vendorProfile/'.$vendor->id, $request['path_address_proof']);
                $vendor['path_address_proof'] = $path;
            }
            $vendor->street = $request->street;
            $vendor->inner_number = $request->inner_number;
            $vendor->outer_number = $request->outer_number;
            $vendor->suburb = $request->suburb;
            $vendor->delegation = $request->delegation;
            $vendor->postal_code = $request->postal_code;
            $vendor->country_id = $request->country_id;
            $vendor->state_id = $request->state_id;
            $vendor->city = $request->city;
            if($request->path_official_identification	 != ''){
                if($vendor->path_official_identification  != null){
                    $document = new Document();
                    $document->table_name = 'vendors';
                    $document->record_id = $vendor->id;
                    $document->path_document = $vendor->path_official_identification;
                    $document->record_column_name = 'path_official_identification';
                    $document->save();

                }
                $path = \Storage::disk('s3')->put('vendorProfile/'.$vendor->id, $request['path_official_identification']);
                $vendor['path_official_identification'] = $path;
            }
            $vendor->key_rfc = $request->key_rfc;
            if($request->path_cover_rfc	 != ''){
                if($vendor->path_cover_rfc  != null){
                    $document = new Document();
                    $document->table_name = 'vendors';
                    $document->record_id = $vendor->id;
                    $document->path_document = $vendor->path_cover_rfc;
                    $document->record_column_name = 'path_cover_rfc';
                    $document->save();

                }
                $path = \Storage::disk('s3')->put('vendorProfile/'.$vendor->id, $request['path_cover_rfc']);
                $vendor['path_cover_rfc'] = $path;
            }
            if($request->path_32d	 != ''){
                if($vendor->path_32d  != null){
                    $document = new Document();
                    $document->table_name = 'vendors';
                    $document->record_id = $vendor->id;
                    $document->path_document = $vendor->path_32d;
                    $document->record_column_name = 'path_32d';
                    $document->save();

                }
                $path = \Storage::disk('s3')->put('vendorProfile/'.$vendor->id, $request['path_32d']);
                $vendor['path_32d'] = $path;
            }
            if( ($request->country_id != '142') && ($request->country_id != '') ){
                $vendor->key_rfc = '-----';
                $vendor->path_cover_rfc = '-----';
                $vendor->path_32d = '-----';
            }
            $vendor->update();
            $vendorStatusForm = false;
            $query = "SELECT COUNT(va.vendor_id) AS 'totalActive' FROM vendor_bank_accounts AS va, bank_accounts AS ba WHERE va.bank_account_id = ba.id AND ba.is_status_complete = 1 AND ba.is_status_active = 1 AND va.vendor_id = ".$vendor->id;
            $accountActives =DB::select( DB::raw($query));
            $query2 = "SELECT COUNT(vs.vendor_id) AS total FROM vendor_services AS vs, vendors AS v WHERE vs.vendor_id = v.id AND v.id = ".$vendor->id;
            $servicesT =DB::select( DB::raw($query2));
            if(
                ($vendor->name == '') || ($vendor->street == '') || ($vendor->path_address_proof == '') ||
                ($vendor->legal_name == '') ||($vendor->contact_name == '') ||
                ($vendor->inner_number	 == '') || ($vendor->outer_number == '') || ($vendor->suburb == '') ||
                ($vendor->delegation == '') || ($vendor->postal_code == '') || ($vendor->country_id == '') ||
                ($vendor->state_id == '') || ($vendor->city == '') || ($accountActives[0]->totalActive == 0) ||
                ($servicesT[0]->total == 0) ||
                ($vendor->key_rfc == '') || ($vendor->path_cover_rfc == '') ||
                ($vendor->mobile == '')  ||
                ($vendor->path_official_identification == '') || ($vendor->path_32d == '')

           ){
            }else{
                $vendorStatusForm = true;
            }
            if( ($request->country_id != '142') && ($request->country_id != '') ){
                $vendor->key_rfc = null;
                $vendor->path_cover_rfc = null;
                $vendor->path_32d = null;
            }
            $vendor->update();
            //$message = $servicesInfo[0];
            $message = __('Successfully updated profile');
            return ['updateVendor' => true, 'message' => $message, 'vendorStatusForm' => $vendorStatusForm, $vendor->toArray(),];

        } catch(\Exception $e){
            $message = __('Cannot update profile');
            return ['updateVendor' => false,'message' => $message, $e];
        }
    }

    public function checkVendorProfile(Request $request){
        try{
            $vendor = Vendor::findorFail($request->vendorId);
            $vendorStatusForm = false;
            $query = "SELECT COUNT(va.vendor_id) AS 'totalActive' FROM vendor_bank_accounts AS va, bank_accounts AS ba WHERE va.bank_account_id = ba.id AND ba.is_status_complete = 1 AND ba.is_status_active = 1 AND va.vendor_id = ".$vendor->id;
            $accountActives =DB::select( DB::raw($query));
            $query2 = "SELECT COUNT(vs.vendor_id) AS total FROM vendor_services AS vs, vendors AS v WHERE vs.vendor_id = v.id AND v.id = ".$vendor->id;
            $servicesT =DB::select( DB::raw($query2));
            if( ($vendor->country_id != '142') && ($vendor->country_id != '') ){
            $vendor->key_rfc = '-----';
            $vendor->path_cover_rfc = '-----';
            $vendor->path_32d = '-----';
            }
            $vendor->update();
            if(
                ($vendor->name == '') || ($vendor->street == '') || ($vendor->path_address_proof == '') ||
                ($vendor->legal_name == '') ||($vendor->contact_name == '') ||
                ($vendor->inner_number	 == '') || ($vendor->outer_number == '') || ($vendor->suburb == '') ||
                ($vendor->delegation == '') || ($vendor->postal_code == '') || ($vendor->country_id == '') ||
                ($vendor->state_id == '') || ($vendor->city == '') || ($accountActives[0]->totalActive == 0) ||
                ($servicesT[0]->total == 0) ||
                ($vendor->key_rfc == '') || ($vendor->path_cover_rfc == '') ||
                ($vendor->mobile == '')  ||
                ($vendor->path_official_identification == '') || ($vendor->path_32d == '')

            ){
            }else{
                $vendorStatusForm = true;
            }
            if( ($vendor->country_id != '142') && ($vendor->country_id != '') ){
            $vendor->key_rfc = null;
            $vendor->path_cover_rfc = null;
            $vendor->path_32d = null;
            }
            $vendor->update();
            return ['vendorStatusForm' => $vendorStatusForm];
            } catch(\Exception $e){
                return ['vendorStatusForm' => false, 'message' => $e];
            }
    }

    public function getStates($id){

        $states = State::where('country_id', (int)$id)->orderBy('id', 'asc')->get();
        if($states!=null){
            return Response::json($states);
        }else{
            return null;
        }

    }

    public function changesVendor(Request $request){

        try{
            //DB::beginTransaction();
            $vendor= Vendor::findorFail((int)$request->vendorId);
            $detectedChanges= array();
            if($vendor->name != $request->name){
                array_push($detectedChanges, __('Full Name').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->name.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->name.'</b>');
            }
            if($vendor->legal_name != $request->legal_name){
                array_push($detectedChanges, __('Legal Name').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->legal_name.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->legal_name.'</b>');
            }
            if($vendor->contact_name != $request->contact_name){
                array_push($detectedChanges, __('Contact name').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->contact_name.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->contact_name.'</b>');
            }
            if($vendor->mobile != $request->mobile){
                array_push($detectedChanges, __('Mobile Phone').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->mobile.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->mobile.'</b>');
            }
            if($vendor->phone != $request->phone){
                array_push($detectedChanges, __('Telephone').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->phone.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->phone.'</b>');
            }
            if($request->path_address_proof != null){
                array_push($detectedChanges, __('Proof of residency').', '.__('was ').'<a href="#" onclick=watchDocument("vendors","path_address_proof",'.$vendor->id.');  style="color: blue; text-decoration-line: underline; font-weight: bold;">'.__('updated').'</a>.');
            }
            if($vendor->street != $request->street){
                array_push($detectedChanges, __('Street Name').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->street.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->street.'</b>');
            }
            if($vendor->outer_number != $request->outer_number){
                array_push($detectedChanges, __('External No.').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->outer_number.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->outer_number.'</b>');
            }
            if($vendor->inner_number != $request->inner_number){
                array_push($detectedChanges, __('Internal No.').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->inner_number.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->inner_number.'</b>');
            }
            if($vendor->suburb != $vendor->suburb){
                array_push($detectedChanges, __('Suburb').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->suburb.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->suburb.'</b>');
            }
            if($vendor->delegation != $request->delegation){
                array_push($detectedChanges, __('Delegacy').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->delegation.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->delegation.'</b>');
            }
            if($vendor->postal_code != $request->postal_code){
                array_push($detectedChanges, __('Zip code').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->postal_code.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->postal_code.'</b>');
            }
            $countryName = Country::where('id', (int) $request->country_id)->get()->first();
            if($vendor->country_id != $request->country_id){
                array_push($detectedChanges, __('Country').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->country->name.' </b>'.__('to').' <b style="font-weight: bold;">'.$countryName->name.'</b>');
            }
            $stateName = State::where('id', (int) $request->state_id)->get()->first();
            if($vendor->state_id != $request->state_id){
                array_push($detectedChanges, __('State').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->state->name.' </b>'.__('to').' <b style="font-weight: bold;">'.$stateName->name.'</b>');
            }
            if($vendor->city != $request->city){
                array_push($detectedChanges, __('City').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->city.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->city.'</b>');
            }
            if($request->path_official_identification != null){
                array_push($detectedChanges, __('Official identification').', '.__('was ').'<a href="#" onclick=watchDocument("vendors","path_official_identification",'.$vendor->id.');  style="color: blue; text-decoration-line: underline; font-weight: bold;">'.__('updated').'</a>.');
            }
            if($vendor->key_rfc != $request->key_rfc){
                array_push($detectedChanges, __('Key RFC').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->key_rfc.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->key_rfc.'</b>');
            }
            if($request->path_cover_rfc != null){
                array_push($detectedChanges, __('Proof of tax status').', '.__('was ').'<a href="#" onclick=watchDocument("vendors","path_cover_rfc",'.$vendor->id.');  style="color: blue; text-decoration-line: underline; font-weight: bold;">'.__('updated').'</a>.');
            }
            if($request->path_32d != null){
                array_push($detectedChanges, __('Tax compliance opinion (32D)').', '.__('was ').'<a href="#" onclick=watchDocument("vendors","path_32d",'.$vendor->id.');  style="color: blue; text-decoration-line: underline; font-weight: bold;">'.__('updated').'</a>.');
            }
            $countChange = 0;

            $servicesInfo = explode(",", $request->vendorServices);
            foreach($vendor->vendorServices as $item){
                $stateRemoval = false;
                foreach($servicesInfo as $key){
                    if($item->service_id == (int)$key){
                        $stateRemoval = true;
                    }
                }
                if($stateRemoval == false){
                    VendorService::destroy($item->id);
                    $countChange = $countChange + 1;
                }

            }
            foreach($servicesInfo as $key){
                if($request->vendorServices != null){
                    $stateAdd = false;
                    foreach($vendor->vendorServices as $item){
                        if($item->service_id == (int)$key){
                            $stateAdd = true;
                        }
                    }
                    if($stateAdd == false){
                        $vendorService = new VendorService();
                        $vendorService->vendor_id = (int)$request->vendorId;
                        $vendorService->service_id = (int)$key;
                        $vendorService->updated_by = auth()->user()->id;
                        $vendorService->save();
                        $countChange = $countChange + 1;
                    }
                }

            }
            if($countChange > 0){
                array_push($detectedChanges, __('Service provided in production').', '.__('was ').__('updated').__('.'));
            }

            $vendor->name = $request->name;
            $vendor->legal_name = $request->legal_name;
            $vendor->contact_name = $request->contact_name;
            $vendor->mobile = $request->mobile;
            $vendor->phone = $request->phone;
            if($request->path_address_proof	 != ''){
                if($vendor->path_address_proof  != null){
                    $document = new Document();
                    $document->table_name = 'vendors';
                    $document->record_id = $vendor->id;
                    $document->path_document = $vendor->path_address_proof;
                    $document->record_column_name = 'path_address_proof';
                    $document->save();

                }
                $path = \Storage::disk('s3')->put('vendorProfile/'.$vendor->id, $request['path_address_proof']);
                $vendor['path_address_proof'] = $path;
            }
            $vendor->street = $request->street;
            $vendor->inner_number = $request->inner_number;
            $vendor->outer_number = $request->outer_number;
            $vendor->suburb = $request->suburb;
            $vendor->delegation = $request->delegation;
            $vendor->postal_code = $request->postal_code;
            $vendor->country_id = $request->country_id;
            $vendor->state_id = $request->state_id;
            $vendor->city = $request->city;
            if($request->path_official_identification	 != ''){
                if($vendor->path_official_identification  != null){
                    $document = new Document();
                    $document->table_name = 'vendors';
                    $document->record_id = $vendor->id;
                    $document->path_document = $vendor->path_official_identification;
                    $document->record_column_name = 'path_official_identification';
                    $document->save();

                }
                $path = \Storage::disk('s3')->put('vendorProfile/'.$vendor->id, $request['path_official_identification']);
                $vendor['path_official_identification'] = $path;
            }
            $vendor->key_rfc = $request->key_rfc;
            if($request->path_cover_rfc	 != ''){
                if($vendor->path_cover_rfc  != null){
                    $document = new Document();
                    $document->table_name = 'vendors';
                    $document->record_id = $vendor->id;
                    $document->path_document = $vendor->path_cover_rfc;
                    $document->record_column_name = 'path_cover_rfc';
                    $document->save();

                }
                $path = \Storage::disk('s3')->put('vendorProfile/'.$vendor->id, $request['path_cover_rfc']);
                $vendor['path_cover_rfc'] = $path;
            }
            if($request->path_32d	 != ''){
                if($vendor->path_32d  != null){
                    $document = new Document();
                    $document->table_name = 'vendors';
                    $document->record_id = $vendor->id;
                    $document->path_document = $vendor->path_32d;
                    $document->record_column_name = 'path_32d';
                    $document->save();

                }
                $path = \Storage::disk('s3')->put('vendorProfile/'.$vendor->id, $request['path_32d']);
                $vendor['path_32d'] = $path;
            }
            if( ($request->country_id != '142') && ($request->country_id != '') ){
                $vendor->key_rfc = null;
                $vendor->path_cover_rfc = null;
                $vendor->path_32d = null;
            }
            $vendor->is_status_complete = true;
            $vendor->status = '2';
            $vendor->color_status = '#ffee58';
            $vendor->revision_number = ((int)$vendor->revision_number)+1;
            $vendor->update();
            $notifyDecline = Notification::where('action', 'Decline Vendor')->where('targeted_user', auth()->user()->id)->where('is_status_activated', true)->get()->first();
            if($notifyDecline != null){
                $notifyDecline->is_status_activated = false;
                $notifyDecline->update();
            }
            $vendor->update();
            $vendorStatusForm = true;
            $message = __('Your profile has been sent for review');
            $query1 = "SELECT u.id AS userId, u.name AS userName, u.email AS userEmail, r.name AS rolName, p.name AS permissionName FROM permissions AS p, role_permissions AS rp, roles AS r, users AS u WHERE p.name = 'Vendor Approve' AND rp.permission_id=p.id AND r.id=rp.role_id AND u.role_id= r.id AND u.status =1";
            $usersNotify =DB::select( DB::raw($query1));
            $flagSendEmail = true;
            $mailsUser = array();
            foreach($usersNotify as $userMail){
                array_push($mailsUser, $userMail->userEmail);
            }
            try{
                Mail::to($mailsUser)->send(new VendorChangeProfile($detectedChanges));
            } catch(\Exception $e){
                $flagSendEmail = false;
                $erro1 = $e;
            }
            foreach($usersNotify as $user){
                if($flagSendEmail){
                    $notification = new Notification();
                    $notification->action = 'Approve Vendor';
                    $notification->description = 'The vendor has submitted its profile for review. Click here for review it.';
                    $notification->action_url = '/vendor';
                    $notification->targeted_user = $user->userId;
                    $notification->created_by = auth()->user()->id;
                    $notification->is_status_activated = true;
                    $notification->save();

                    $vendorReview = new VendorNotification();
                    $vendorReview->vendor_id = $vendor->id;
                    $vendorReview->user_id = $user->userId;
                    $vendorReview->revision_number =((int)$vendor->revision_number);
                    $vendorReview->created_by = auth()->user()->id;
                    $vendorReview->text_help = implode("','",$detectedChanges);
                    $vendorReview->save();
                }
            }
            DB::commit();
            return ['updateVendor' => true, 'btnSuccess' => __('Roger that'), 'message' => $message, 'vendorStatusForm' => $vendorStatusForm, $vendor->toArray(), 'changes' => $detectedChanges, $vendorReview->toArray()];

        } catch(\Exception $e){
            DB::rollback();
            $message = __('System error could not be sent for rereview');
            return ['updateVendor' => false, 'btnSuccess' => __('Roger that'), 'message' => $message, $e];
        }


    }


    public function addBankChanges(Request $request){
        try{
            DB::beginTransaction();
            $detectedChanges= array();
            $vendor = Vendor::findorFail( (int)$request->vendorId );
            if($vendor->name != $request->name){
                array_push($detectedChanges, __('Full Name').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->name.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->name.'</b>');
            }
            if($vendor->legal_name != $request->legal_name){
                array_push($detectedChanges, __('Legal Name').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->legal_name.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->legal_name.'</b>');
            }
            if($vendor->contact_name != $request->contact_name){
                array_push($detectedChanges, __('Contact name').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->contact_name.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->contact_name.'</b>');
            }
            if($vendor->mobile != $request->mobile){
                array_push($detectedChanges, __('Mobile Phone').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->mobile.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->mobile.'</b>');
            }
            if($vendor->phone != $request->phone){
                array_push($detectedChanges, __('Telephone').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->phone.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->phone.'</b>');
            }
            if($request->path_address_proof != null){
                array_push($detectedChanges, __('Proof of residency').', '.__('was ').'<a href="#" onclick=watchDocument("vendors","path_address_proof",'.$vendor->id.');  style="color: blue; text-decoration-line: underline; font-weight: bold;">'.__('updated').'</a>.');
            }
            if($vendor->street != $request->street){
                array_push($detectedChanges, __('Street Name').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->street.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->street.'</b>');
            }
            if($vendor->outer_number != $request->outer_number){
                array_push($detectedChanges, __('External No.').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->outer_number.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->outer_number.'</b>');
            }
            if($vendor->inner_number != $request->inner_number){
                array_push($detectedChanges, __('Internal No.').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->inner_number.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->inner_number.'</b>');
            }
            if($vendor->suburb != $vendor->suburb){
                array_push($detectedChanges, __('Suburb').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->suburb.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->suburb.'</b>');
            }
            if($vendor->delegation != $request->delegation){
                array_push($detectedChanges, __('Delegacy').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->delegation.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->delegation.'</b>');
            }
            if($vendor->postal_code != $request->postal_code){
                array_push($detectedChanges, __('Zip code').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->postal_code.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->postal_code.'</b>');
            }
            $countryName = Country::where('id', (int) $request->country_id)->get()->first();
            if($vendor->country_id != $request->country_id){
                array_push($detectedChanges, __('Country').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->country->name.' </b>'.__('to').' <b style="font-weight: bold;">'.$countryName->name.'</b>');
            }
            $stateName = State::where('id', (int) $request->state_id)->get()->first();
            if($vendor->state_id != $request->state_id){
                array_push($detectedChanges, __('State').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->state->name.' </b>'.__('to').' <b style="font-weight: bold;">'.$stateName->name.'</b>');
            }
            if($vendor->city != $request->city){
                array_push($detectedChanges, __('City').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->city.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->city.'</b>');
            }
            if($request->path_official_identification != null){
                array_push($detectedChanges, __('Official identification').', '.__('was ').'<a href="#" onclick=watchDocument("vendors","path_official_identification",'.$vendor->id.');  style="color: blue; text-decoration-line: underline; font-weight: bold;">'.__('updated').'</a>.');
            }
            if($vendor->key_rfc != $request->key_rfc){
                array_push($detectedChanges, __('Key RFC').' '.__('changed from').' <b style="font-weight: bold;">'.$vendor->key_rfc.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->key_rfc.'</b>');
            }
            if($request->path_cover_rfc != null){
                array_push($detectedChanges, __('Proof of tax status').', '.__('was ').'<a href="#" onclick=watchDocument("vendors","path_cover_rfc",'.$vendor->id.');  style="color: blue; text-decoration-line: underline; font-weight: bold;">'.__('updated').'</a>.');
            }
            if($request->path_32d != null){
                array_push($detectedChanges, __('Tax compliance opinion (32D)').', '.__('was ').'<a href="#" onclick=watchDocument("vendors","path_32d",'.$vendor->id.');  style="color: blue; text-decoration-line: underline; font-weight: bold;">'.__('updated').'</a>.');
            }
            $countChange = 0;

            $servicesInfo = explode(",", $request->vendorServices);
            foreach($vendor->vendorServices as $item){
                $stateRemoval = false;
                foreach($servicesInfo as $key){
                    if($item->service_id == (int)$key){
                        $stateRemoval = true;
                    }
                }
                if($stateRemoval == false){
                    VendorService::destroy($item->id);
                    $countChange = $countChange + 1;
                }

            }
            foreach($servicesInfo as $key){
                if($request->vendorServices != null){
                    $stateAdd = false;
                    foreach($vendor->vendorServices as $item){
                        if($item->service_id == (int)$key){
                            $stateAdd = true;
                        }
                    }
                    if($stateAdd == false){
                        $vendorService = new VendorService();
                        $vendorService->vendor_id = (int)$request->vendorId;
                        $vendorService->service_id = (int)$key;
                        $vendorService->updated_by = auth()->user()->id;
                        $vendorService->save();
                        $countChange = $countChange + 1;
                    }
                }

            }
            if($countChange > 0){
                array_push($detectedChanges, __('Service provided in production').', '.__('was ').__('updated').__('.'));
            }

            $vendor->name = $request->name;
            $vendor->legal_name = $request->legal_name;
            $vendor->contact_name = $request->contact_name;
            $vendor->mobile = $request->mobile;
            $vendor->phone = $request->phone;
            if($request->path_address_proof	 != ''){
                if($vendor->path_address_proof  != null){
                    $document = new Document();
                    $document->table_name = 'vendors';
                    $document->record_id = $vendor->id;
                    $document->path_document = $vendor->path_address_proof;
                    $document->record_column_name = 'path_address_proof';
                    $document->save();

                }
                $path = \Storage::disk('s3')->put('vendorProfile/'.$vendor->id, $request['path_address_proof']);
                $vendor['path_address_proof'] = $path;
            }
            $vendor->street = $request->street;
            $vendor->inner_number = $request->inner_number;
            $vendor->outer_number = $request->outer_number;
            $vendor->suburb = $request->suburb;
            $vendor->delegation = $request->delegation;
            $vendor->postal_code = $request->postal_code;
            $vendor->country_id = $request->country_id;
            $vendor->state_id = $request->state_id;
            $vendor->city = $request->city;
            if($request->path_official_identification	 != ''){
                if($vendor->path_official_identification  != null){
                    $document = new Document();
                    $document->table_name = 'vendors';
                    $document->record_id = $vendor->id;
                    $document->path_document = $vendor->path_official_identification;
                    $document->record_column_name = 'path_official_identification';
                    $document->save();

                }
                $path = \Storage::disk('s3')->put('vendorProfile/'.$vendor->id, $request['path_official_identification']);
                $vendor['path_official_identification'] = $path;
            }
            $vendor->key_rfc = $request->key_rfc;
            if($request->path_cover_rfc	 != ''){
                if($vendor->path_cover_rfc  != null){
                    $document = new Document();
                    $document->table_name = 'vendors';
                    $document->record_id = $vendor->id;
                    $document->path_document = $vendor->path_cover_rfc;
                    $document->record_column_name = 'path_cover_rfc';
                    $document->save();

                }
                $path = \Storage::disk('s3')->put('vendorProfile/'.$vendor->id, $request['path_cover_rfc']);
                $vendor['path_cover_rfc'] = $path;
            }
            if($request->path_32d	 != ''){
                if($vendor->path_32d  != null){
                    $document = new Document();
                    $document->table_name = 'vendors';
                    $document->record_id = $vendor->id;
                    $document->path_document = $vendor->path_32d;
                    $document->record_column_name = 'path_32d';
                    $document->save();

                }
                $path = \Storage::disk('s3')->put('vendorProfile/'.$vendor->id, $request['path_32d']);
                $vendor['path_32d'] = $path;
            }
            if( ($request->country_id != '142') && ($request->country_id != '') ){
                $vendor->key_rfc = null;
                $vendor->path_cover_rfc = null;
                $vendor->path_32d = null;
            }
            $vendor->is_status_complete = true;
            $vendor->status = '2';
            $vendor->color_status = '#ffee58';
            $vendor->revision_number = ((int)$vendor->revision_number)+1;
            $vendor->update();
            $notifyDecline = Notification::where('action', 'Decline Vendor')->where('targeted_user', auth()->user()->id)->where('is_status_activated', true)->get()->first();
            if($notifyDecline != null){
                $notifyDecline->is_status_activated = false;
                $notifyDecline->update();
            }
            $vendor->update();

            if((int) $request->type == 1){
                $bankAccount = new BankAccount();
            }else{
                $bankAccount = BankAccount::findorFail( (int)$request->idBank );
                if($bankAccount->bank != $request->bank){
                    array_push($detectedChanges, __('In the account ').'<b style="font-weight: bold;">'.substr($bankAccount->account_number, -4).'</b>, '.__('Bank').' '.__('changed from').' <b style="font-weight: bold;">'.$bankAccount->bank.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->bank.'</b>');
                }
                if($bankAccount->account_owner != $request->account_owner){
                    array_push($detectedChanges, __('In the account ').'<b style="font-weight: bold;">'.substr($bankAccount->account_number, -4).'</b>, '.__('Account owner').' '.__('changed from').' <b style="font-weight: bold;">'.$bankAccount->account_owner.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->account_owner.'</b>');
                }
                if($bankAccount->account_number != $request->account_number){
                    array_push($detectedChanges, __('In the account ').'<b style="font-weight: bold;">'.substr($bankAccount->account_number, -4).'</b>, '.__('Account No.').' '.__('changed from').' <b style="font-weight: bold;">'.$bankAccount->account_number.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->account_number.'</b>');
                }
                if($request->countrySelect == '142'){
                    if($bankAccount->clabe != $request->clabe){
                        array_push($detectedChanges, __('In the account ').'<b style="font-weight: bold;">'.substr($bankAccount->account_number, -4).'</b>, '.__('CLABE').' '.__('changed from').' <b style="font-weight: bold;">'.$bankAccount->clabe.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->clabe.'</b>');
                    }
                }else{
                    if($bankAccount->swift != $request->swift){
                        array_push($detectedChanges, __('In the account ').'<b style="font-weight: bold;">'.substr($bankAccount->account_number, -4).'</b>, '.__('Key SWIFT/BIC').' '.__('changed from').' <b style="font-weight: bold;">'.$bankAccount->swift.' </b>'.__('to').' <b style="font-weight: bold;">'.$request->swift.'</b>');
                    }
                }
                if($request->path_account_statement != null){
                    array_push($detectedChanges, __('In the account ').'<b style="font-weight: bold;">'.substr($bankAccount->account_number, -4).'</b>, '.__('Account statement').', '.__('was ').'<a href="#" onclick=watchDocument("bank_accounts","path_account_statement",'.$bankAccount->id.');  style="color: blue; text-decoration-line: underline; font-weight: bold;">'.__('updated').'</a>.');
                }
            }
            $bankAccount->bank = $request->bank;
            $bankAccount->account_owner = $request->account_owner;
            $bankAccount->account_number = $request->account_number;
            $bankAccount->clabe = $request->clabe;
            $bankAccount->swift = $request->swift;
            if($request->countrySelect == '142'){
                $bankAccount->swift = null;
            }else{
                $bankAccount->clabe = null;
            }
            $bankAccount->is_status_complete = true;
            $bankAccount->save();
            if((int) $request->type == 1){
                if($request->path_account_statement != ''){
                    $path = \Storage::disk('s3')->put('bankAccounts/'.$bankAccount->id, $request['path_account_statement']);
                    $bankAccount['path_account_statement'] = $path;
                    $bankAccount->save();
                }
                $vendorBankAccount = new VendorBankAccounts();
                $vendorBankAccount->vendor_id = $request->vendorId;
                $vendorBankAccount->bank_account_id = $bankAccount->id;
                $vendorBankAccount->created_by = auth()->user()->id;
                $vendorBankAccount->save();
                array_push($detectedChanges, __('The bank account was created ').' <b style="font-weight: bold;">'.substr($bankAccount->account_number, -4).' </b>.');
            }else{
                if($request->path_account_statement != ''){
                    if($bankAccount->path_account_statement  != null){
                        $document = new Document();
                        $document->table_name = 'vendors';
                        $document->record_id = $bankAccount->id;
                        $document->path_document = $bankAccount->path_account_statement;
                        $document->record_column_name = 'path_account_statement';
                        $document->save();
                    }
                    $path = \Storage::disk('s3')->put('bankAccounts/'.$bankAccount->id, $request['path_account_statement']);
                    $bankAccount['path_account_statement'] = $path;
                    $bankAccount->save();
                }
            }
            $vendor->is_status_complete = true;
            $vendor->status = '2';
            $vendor->color_status = '#ffee58';
            $vendor->revision_number = ((int)$vendor->revision_number)+1;
            $vendor->update();
            $notifyDecline = Notification::where('action', 'Decline Vendor')->where('targeted_user', auth()->user()->id)->where('is_status_activated', true)->get()->first();
            if($notifyDecline != null){
                $notifyDecline->is_status_activated = false;
                $notifyDecline->update();
            }
            $query1 = "SELECT u.id AS userId, u.name AS userName, u.email AS userEmail, r.name AS rolName, p.name AS permissionName FROM permissions AS p, role_permissions AS rp, roles AS r, users AS u WHERE p.name = 'Vendor Approve' AND rp.permission_id=p.id AND r.id=rp.role_id AND u.role_id= r.id AND u.status =1";
            $usersNotify =DB::select( DB::raw($query1));
            $flagSendEmail = true;
            $mailsUser = array();
            foreach($usersNotify as $userMail){
                array_push($mailsUser, $userMail->userEmail);
            }
            try{
                Mail::to($mailsUser)->send(new VendorChangeProfile($detectedChanges));
            } catch(\Exception $e){
                $flagSendEmail = false;
                $erro1 = $e;
            }
            foreach($usersNotify as $user){
                if($flagSendEmail){
                    $notification = new Notification();
                    $notification->action = 'Approve Vendor';
                    $notification->description = 'The vendor has submitted its profile for review. Click here for review it.';
                    $notification->action_url = '/vendor';
                    $notification->targeted_user = $user->userId;
                    $notification->created_by = auth()->user()->id;
                    $notification->is_status_activated = true;
                    $notification->save();

                    $vendorReview = new VendorNotification();
                    $vendorReview->vendor_id = $vendor->id;
                    $vendorReview->user_id = $user->userId;
                    $vendorReview->revision_number =((int)$vendor->revision_number);
                    $vendorReview->created_by = auth()->user()->id;
                    $vendorReview->text_help = implode("','",$detectedChanges);
                    // if( (int) $request->type == 2){
                    //     $vendorReview->text_help_title = __('Account updated ').substr($bankAccount->account_number, -4);
                    // }
                    $vendorReview->save();
                }
            }
            DB::commit();
            return ['bank' => $vendorReview->toArray(),'updateVendor' => true, 'btnSuccess' => __('Roger that'), 'message' => __('Your profile has been sent for review')];
        } catch(\Exception $e){
            DB::rollback();
            $message = __('System error could not be sent for rereview');
            return ['updateVendor' => false, $e, 'btnSuccess' => __('Roger that'), 'message' => $message];
        }

    }




    public function addBankAccount(Request $request){
        try{
            $bankAccount = new BankAccount();

            $bankAccount->bank = $request->bank;
            $bankAccount->account_owner = $request->account_owner;
            $bankAccount->account_number = $request->account_number;
            $bankAccount->clabe = $request->clabe;
            $bankAccount->swift = $request->swift;
            $bankAccount->save();

            if($request->path_account_statement != ''){
                $path = \Storage::disk('s3')->put('bankAccounts/'.$bankAccount->id, $request['path_account_statement']);
                $bankAccount['path_account_statement'] = $path;
                $bankAccount->save();
            }
            if($request->countrySelect == '142'){
                $bankAccount->swift = '0000';
            }else{
                $bankAccount->clabe = '0000';
            }
            if( ($bankAccount->bank == '') || ($bankAccount->account_owner == '') || ($bankAccount->account_number == '') || ($bankAccount->clabe == '') || ($bankAccount->path_account_statement == '') || ($bankAccount->swift == '') ){
                $bankAccount->is_status_complete = false;
            }else{
                $bankAccount->is_status_complete = true;
            }
            if($request->countrySelect == '142'){
                $bankAccount->swift = null;
            }else{
                $bankAccount->clabe = null;
            }
            $bankAccount->save();

            $vendorBankAccount = new VendorBankAccounts();
            $vendorBankAccount->vendor_id = $request->vendorId;
            $vendorBankAccount->bank_account_id = $bankAccount->id;
            $vendorBankAccount->created_by = auth()->user()->id;
            $vendorBankAccount->save();


            return ['saveBankAccount' => true, $bankAccount->toArray(), 'prueba' =>$request->countrySelect];




        } catch(\Exception $e){
            return ['saveBankAccount' => false, $e];
        }

    }

    public function deactivateFeedBackVendors(Request $request){

        $feedbacksNotifys = Notification::where('targeted_user', auth()->user()->id)->where('action', 'Feedback Vendor')->where('is_status_activated', true)->get();
        foreach($feedbacksNotifys as $notify){
            $notify->is_status_activated = false;
            $notify->update();
        }

    }




    public function editBankAccount(Request $request){
        try{
            $bankAccount = BankAccount::findorFail((int)$request->accountId);

            $bankAccount->bank = $request->bank;
            $bankAccount->account_owner = $request->account_owner;
            $bankAccount->account_number = $request->account_number;
            $bankAccount->clabe = $request->clabe;
            $bankAccount->swift = $request->swift;
            $bankAccount->update();

            if($request->path_account_statement != ''){
                if($bankAccount->path_account_statement  != null){
                    $document = new Document();
                    $document->table_name = 'vendors';
                    $document->record_id = $bankAccount->id;
                    $document->path_document = $bankAccount->path_account_statement;
                    $document->record_column_name = 'path_account_statement';
                    $document->save();

                }
                $path = \Storage::disk('s3')->put('bankAccounts/'.$bankAccount->id, $request['path_account_statement']);
                $bankAccount['path_account_statement'] = $path;
                $bankAccount->save();
            }
            if($request->countrySelect == '142'){
                $bankAccount->swift = '0000';
            }else{
                $bankAccount->clabe = '0000';
            }
            if( ($bankAccount->bank == '') || ($bankAccount->account_owner == '') || ($bankAccount->account_number == '') || ($bankAccount->clabe == '') || ($bankAccount->path_account_statement == '') || ($bankAccount->swift == '') ){
                $bankAccount->is_status_complete = false;
            }else{
                $bankAccount->is_status_complete = true;
            }
            if($request->countrySelect == '142'){
                $bankAccount->swift = null;
            }else{
                $bankAccount->clabe = null;
            }
            $bankAccount->update();


            return ['saveBankAccount' => true, $bankAccount->toArray(),];




        } catch(\Exception $e){
            return ['saveBankAccount' => false, $e];
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        //
    }

    public function showPreview(Request $request){
        // dd($_FILES['file']);
$field=$request['field'];
// echo $field;
        $binario_nombre_temporal=$_FILES[$field]['tmp_name'] ;
        $binario_contenido = addslashes(fread(fopen($binario_nombre_temporal, "rb"), filesize($binario_nombre_temporal)));
        // $doc->archivo_binario=$binario_contenido;
        $type=$_FILES[$field]['type'];
        $contenido=stripslashes($binario_contenido);
        header("Content-type: $type");
        print $contenido;
    }

    public function deleteAccount(Request $request){

        try{
            $bankAccount = BankAccount::where('id', $request->idAccount)->get()->first();
            $bankAccount->is_status_active = false;
            $bankAccount->update();
            $message = __('Account successfully deleted');

            return ['deleteBankAccount' => true, 'message' => $message];
        } catch(\Exception $e){
            $message = __('This account could not be deleted');
            return ['deleteBankAccount' => false, 'message' => $message];
        }



    }


    public function watchDocument(Request $request){
        $documentFile = DB::table($request->table)
        ->where('id', (int)$request->id)
        ->pluck($request->field)
        ->first();


        $contenido = \Storage::disk('s3')->get($documentFile);
        $gettype=explode('.',$documentFile);
        header("Content-type: .$gettype[1]");
        print $contenido;

    }


    public function resendReviewsEmail(Request $request){
        try{
            $vendor = Vendor::findorFail( (int)$request->vendorId );
            $reviews = VendorNotification::where('vendor_id', $vendor->id)->where('revision_number', $vendor->revision_number)->where('is_review', false)->get();
            foreach($reviews as $review){
                Mail::to($review->user->email)->send(new VendorRemindReviewers($vendor->name));
            }
            $message = __('Reminders were successfully sent');
            return ['resendEmail' => true, 'message' => $message];
        } catch(\Exception $e){
            $message = __('A problem occurred when sending the reminder');
            return ['resendEmail' => false, 'message' => $message, $e];

        }

    }

    public function resendVendorEmail(Request $request){
        try{
            $vendor = Vendor::findorFail( (int)$request->vendorId );
            Mail::to($vendor->user->email)->send(new VendorRemindVendor($vendor));
            $message = __('Reminders were successfully sent');
            return ['resendEmail' => true, 'message' => $message];
        } catch(\Exception $e){
            $message = __('A problem occurred when sending the reminder');
            return ['resendEmail' => false, 'message' => $message, $e];

        }

    }


    public function sendInformationVendor(Request $request){
        try{
            DB::beginTransaction();
            if( (auth()->user()->role->name == 'Vendor') ){
                $vendor = Vendor::findorFail($request->vendorId);
                $query1 = "SELECT u.id AS userId, u.name AS userName, u.email AS userEmail, r.name AS rolName, p.name AS permissionName FROM permissions AS p, role_permissions AS rp, roles AS r, users AS u WHERE p.name = 'Vendor Approve' AND rp.permission_id=p.id AND r.id=rp.role_id AND u.role_id= r.id AND u.status =1";
                $usersNotify =DB::select( DB::raw($query1));
                $flagSendEmail = true;
                $mailsUser = array();
                foreach($usersNotify as $userMail){
                    array_push($mailsUser, $userMail->userEmail);
                }
                try{
                    Mail::to($mailsUser)->send(new VendorProfileComplete('email'));
                } catch(\Exception $e){
                    $flagSendEmail = false;
                    $erro1 = $e;
                }
                foreach($usersNotify as $user){
                    if($flagSendEmail){
                        $notification = new Notification();
                        $notification->action = 'Approve Vendor';
                        $notification->description = 'The vendor has submitted its profile for review. Click here for review it.';
                        $notification->action_url = '/vendor';
                        $notification->targeted_user = $user->userId;
                        $notification->created_by = auth()->user()->id;
                        $notification->is_status_activated = true;
                        $notification->save();

                        $vendorReview = new VendorNotification();
                        $vendorReview->vendor_id = $vendor->id;
                        $vendorReview->user_id = $user->userId;
                        $vendorReview->revision_number =((int)$vendor->revision_number)+1;
                        $vendorReview->created_by = auth()->user()->id;
                        $vendorReview->save();
                    }
                }
                if($flagSendEmail){
                    $vendor->is_status_complete = true;
                    $vendor->status = '2';
                    $vendor->color_status = '#ffee58';
                    $vendor->revision_number = ((int)$vendor->revision_number)+1;
                    $vendor->update();
                    $notifyDecline = Notification::where('action', 'Decline Vendor')->where('targeted_user', auth()->user()->id)->where('is_status_activated', true)->get()->first();
                    if($notifyDecline != null){
                        $notifyDecline->is_status_activated = false;
                        $notifyDecline->update();
                    }
                    DB::commit();
                    return ['vendorComplete' => true, 'btnSuccess' => __('Roger that'), 'message' => __('Your profile has been sent for review')];
                }else{
                    DB::rollback();
                    return ['vendorComplete' => false, 'message' => __('System error could not be sent for review'), $e];
                }
            }
        } catch(\Exception $e){
            DB::rollback();
            return ['vendorComplete' => false, 'btnSuccess' => __('Roger that'), 'message' => __('System error could not be sent for review'), $e];
        }
    }

    public function vendorFilter(Request $request){
        if($request->filterType != null){
            $countType = count($request->filterType);
        }else{
            $countType = 0;
        }
        if($countType == 0){
            $vendors = Vendor::where('is_active', true)->get();
        }
        if($countType == 1){
            $vendors = Vendor::where('is_active', true)->where('status', $request->filterType[0])->get();
        }
        if($countType == 2){
            $vendors = Vendor::where('is_active', true)->where('status', $request->filterType[0])->orWhere('status', $request->filterType[1])->get();
        }
        if($countType == 3){
            $vendors = Vendor::where('is_active', true)->where('status', $request->filterType[0])->orWhere('status', $request->filterType[1])->orWhere('status', $request->filterType[2])->get();
        }
        if($countType == 4){
            $vendors = Vendor::where('is_active', true)->where('status', $request->filterType[0])->orWhere('status', $request->filterType[1])->orWhere('status', $request->filterType[2])->orWhere('status', $request->filterType[3])->get();
        }
        if($countType == 5){
            $vendors = Vendor::where('is_active', true)->where('status', $request->filterType[0])->orWhere('status', $request->filterType[1])->orWhere('status', $request->filterType[2])->orWhere('status', $request->filterType[3])->orWhere('status', $request->filterType[4])->get();
        }
        $servicesVendors = array();
        $reviewsUser = array();
        $countBudgetVendor = array();
        foreach($vendors as $vendor){
            $services = array();
            array_push($countBudgetVendor, count($vendor->vendorBudgetAccounts) );
            $reviewsVendor = VendorNotification::where('user_id', auth()->user()->id)->where('revision_number', $vendor->revision_number)->where('vendor_id', $vendor->id)->get();
            if( count($reviewsVendor) >0 ){
                array_push($reviewsUser, $reviewsVendor);
            }
            foreach($vendor->vendorServices as $item){
                array_push($services, $item->service);
            }
            array_push($servicesVendors, $services);
        }
        if($vendors!=null){
            $permissionAsingUser = false;
            if(User::hasPermissions("Vendor Create User")){
                $permissionAsingUser = true;
            }
            $permissionDeleteVendor = false;
            if(User::hasPermissions("Vendor Delete")){
                $permissionDeleteVendor = true;
            }
            return [$vendors->toArray(), $servicesVendors,'permissionAsingUser' => $permissionAsingUser , $reviewsUser, 'permissionDeleteVendor'=>$permissionDeleteVendor, $countBudgetVendor];
        }else{
            return null;
        }
    }



    public function asigUserVendor(Request $request){
        try{
            $vendor = Vendor::findorFail((int)$request->vendorId);
            $name = '';
            if($vendor->contact_name != null){
                $name = $vendor->contact_name;
            }
            if($vendor->legal_name != null){
                $name = $vendor->legal_name;
            }
            if($vendor->name != null){
                $name = $vendor->name;
            }
            $password2 = Str::random(10);
            $userInformation= new User;
            $userInformation->role_id = '2';
            $userInformation->name = $name;
            $userInformation->password = $password2;
            $userInformation->email = $request->email;
            $userVendor= new User;
            $userVendor->role_id = '2';
            $userVendor->name = $name;
            $userVendor->change_password = false;
            $userVendor->password = bcrypt($password2);
            $userVendor->email = $request->email;
            $userVendor->created_by = auth()->user()->id;
            $flagSendEmail = true;
            $userVendor->save();
            try{
                Mail::to($userInformation->email)->send(new EmailInformation($userInformation));
            } catch(\Exception $e){
                $flagSendEmail = false;
            }
            if($flagSendEmail){
                $vendor->user_id = $userVendor->id;
                $vendor->status = '1';
                $vendor->color_status = '#ffa726';
                $vendor->update();
                return ['save_user' => true, 'vendor_id' => $vendor->id, 'vendor_color' =>$vendor->color_status];
            }else{
                $userVendor->delete();
                $erro_message = __("A conflict occurred when sending the email.");
                return ['save_user' => false, 'error_message' => $erro_message ];
            }
        } catch(\Exception $e){
            $userUnique = User::where('email', $request->email)->count();
            if($userUnique == 0){
                $erro_message = __("Sorry, it couldn't be added.");
            }else{
                $erro_message = __("This email already exists");
            }
            return ['save_user' => false, 'error_message' => $erro_message ];
        }





    }



    public function approveDataVendor(Request $request){
        //Approval type
        //0 Decline
        //1 Approve
        try{
            DB::beginTransaction();
            $vendor = Vendor::findorFail( (int)$request->vendorId );
            $query1 = "SELECT * FROM notifications WHERE action = 'Approve Vendor' AND is_status_activated = 1 AND targeted_user = ".auth()->user()->id;
            $queryResult =DB::select( DB::raw($query1));
            if($queryResult != null){
                $userNotify = Notification::findorFail((int)$queryResult[0]->id);
                $userNotify->is_status_activated = false;
                $userNotify->update();
            }
            $feedback = VendorNotification::where('vendor_id', $vendor->id)->where('revision_number', $vendor->revision_number)->where('user_id', auth()->user()->id)->get()->first();
            $feedback->is_review = true;
            if($request->approvalType){
                $message = __('You have approved this profile');
            }else{
                $feedback->motive = $request->motive;
                $message = __('You have rejected this profile');
                $notification = new Notification();
                $notification->action = 'Feedback Vendor';
                $notification->description = 'A reviewer has commented your profile';
                $notification->action_url = '/vendor/'.$vendor->id.'/edit';
                $notification->targeted_user = $vendor->user->id;
                $notification->created_by = auth()->user()->id;
                $notification->is_status_activated = true;
                $notification->save();
            }
            $feedback->save();
            $feedbackTotal = VendorNotification::where('revision_number', $vendor->revision_number)->where('vendor_id', $vendor->id)->get();
            $feedbackReview = VendorNotification::where('revision_number', $vendor->revision_number)->where('vendor_id', $vendor->id)->where('is_review', 1)->get();
            $feedbackApprove = VendorNotification::where('is_review', 1)->where('revision_number', $vendor->revision_number)->where('vendor_id', $vendor->id)->where('motive', null)->get();
            if(count($feedbackTotal) == count($feedbackReview)){
                $notification = new Notification();
                if(count($feedbackApprove) == count($feedbackTotal)){
                    $notification->action = 'Agreed Vendor';
                    $notification->description = 'Your profile has been approved by every reviewer.';
                    $vendor->status = '3';
                    $vendor->color_status = '#64b5f6';
                    $vendor->is_status_approved = true;
                    $vendor->update();
                    Mail::to($vendor->user->email)->send(new VendorReviewProfile($vendor));
                    $notification->action_url = '/vendor/'.$vendor->id.'/edit';
                    $notification->targeted_user = $vendor->user->id;
                    $notification->created_by = auth()->user()->id;
                    $notification->is_status_activated = true;
                    $notification->save();
                }else{
                    $notification->action = 'Decline Vendor';
                    $notification->description = 'Your profile has pending comments, please edit it and re-submit for review.';
                    $vendor->status = '1';
                    $vendor->color_status = '#ffa726';
                    $vendor->is_status_complete = false;
                    $vendor->update();
                    Mail::to($vendor->user->email)->send(new VendorReviewProfile($vendor));
                    $notification->action_url = '/vendor/'.$vendor->id.'/edit';
                    $notification->targeted_user = $vendor->user->id;
                    $notification->created_by = auth()->user()->id;
                    $notification->is_status_activated = true;
                    $notification->save();
                }
            }else{
                if($request->approvalType){
                }else{
                    Mail::to($vendor->user->email)->send(new VendorFeedbackProfile($feedback, $vendor));
                }

            }
            DB::commit();
            return ['save_info' => true, 'message' => $message, 'btnText' => __('Roger that')];
        } catch(\Exception $e){
            DB::rollback();
            $message = __('There was an error in making your request');
            return ['save_info' => false, 'message' => $message, 'btnText' => __('Roger that'), 'error' => $e ];
        }

    }

function vendorAdd(Request $request){
    $vendor = new Vendor();
    $vendor->name = $request->name;
    $vendor->status = '0';
    $vendor->color_status = '#e57373';
    $vendor->save();

    return ['save_vendor'=>true,'id_vendor'=>$vendor->id];
}


}
