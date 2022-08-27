<?php

namespace App\Http\Controllers;

use App\Models\Ordini;
use App\Models\Partner;
use App\Models\Prodotti;
use App\Models\ProdottiPartner;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule as ValidationRule;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\DataTables;

class PartnerController extends Controller
{
    /**
     * Create a new controller instance.
     * 
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Mostra tutti i partner
     */
    public function show(){
        if(request()->ajax()) {
            $partnerList = Partner::select('external_id', 'titolo', 'mail', 'recapito')
                                    ->whereNull('deleted_at');
            
            return Datatables::of($partnerList)
                                ->editColumn('action', function($row){
                        
                                    $btn = '<a href="'.route('listino', $row->external_id).'" data-toggle="tooltip" data-placement="top" title="Crea Listino"><i class="fas fa-book text-orange mr-3"></i></a>'.
                                           '<a href="'.route('detailPartner', $row->external_id).'" data-toggle="tooltip" data-placement="top" title="Visualizza"><i class="fa fa-eye text-primary mr-3"></i></a>'.
                                           '<a href="'.route('formPartner', $row->external_id).'" data-toggle="tooltip" data-placement="top" title="Modifica"><i class="fa fa-edit text-warning mr-3"></i></a>'.  
                                           '<a href="'.route('deletePartner', $row->external_id).'" onclick="return confirm(\'Procedere con la cancellazione del partner?\')" data-toggle="tooltip" data-placement="top" title="Elimina"><i class="fa fa-trash text-danger"></i></a>';
                                    return $btn;
                                })
                                ->rawColumns(['action'])
                                ->make(true);
        }
        return view('partner.show');
    }

    /**
     * Mostra il form per la creazione di un partner, se idPartner non è nullo recupera i valori di quel partner
     */
    public function formPartner($idPartner = null){
        $partnerData = null;

        if(isset($idPartner)){
            $partnerData = Partner::where('external_id', $idPartner)->first();
        }

        return view('partner.form')
                ->withPartnerData($partnerData);
    }

    /**
     * Aggiunge o modifica un partner
     */
    public function addUpdatePartner(Request $request){
        //validazione
        $validator = Validator::make($request->all(), [
            'titolo' => ['required', Rule::unique('partner')->ignore($request->ext_id, 'external_id')],
            'mail' => ['email', 'nullable'],
            'tel' => ['numeric', 'nullable'],
            'image' => ['mimes:jpg,jpeg,png', 'max:5000']
        ]);

        if($validator->fails()){
            return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
        }

        $path = generateFilePath($request->path_image, $request->file('image'), 'partner');

        $uuid = generateUuid($request->ext_id);
        
        try{
            $partner = Partner::updateOrCreate(
                [ 'external_id' => $uuid ],
                [
                    'titolo' => $request->titolo,
                    'mail' => $request->mail,
                    'recapito' => $request->tel,
                    'foto' => $path
                ]
            );

            if($partner->wasRecentlyCreated){
                return redirect()
                        ->route('showPartner')
                        ->with('success', 'Partner creato con successo');
            }else{
                return redirect()
                        ->route('showPartner')
                        ->with('warning', 'Partner aggiornato con successo');
            }

        }catch(QueryException $ex){
            return redirect()
                    ->back()
                    ->withInput()
                    ->with('danger', "Errore durante l'inserimento di un partner");
        }
    }

    /**
     * Mostra un pagina con info varie del partner
     */
    public function detailPartner($idPartner){
        $partnerData = Partner::where('external_id', $idPartner)->first();

        //recupero i prodotti associati al partner
        $prodottiAssociatiList = ProdottiPartner::select('prodotti_partner.id AS id_associazione', 'prodotti.titolo AS nome_prodotto', 'prezzo', 'prodotti_partner.prodotto_id AS prodotto')
                                                    ->join('prodotti', 'prodotti_partner.prodotto_id', '=', 'prodotti.external_id')
                                                    ->where('prodotti_partner.partner_id', $idPartner)
                                                    ->whereNull('prodotti_partner.deleted_at')
                                                    ->get();

        //recupero gli ordini associati al partner
        $ordini = Ordini::select('ordini.id', 'clienti.nome', 'clienti.cognome', 'totale')
                            ->join('clienti', 'clienti.id', '=', 'ordini.id_cliente')
                            ->where('id_partner', $idPartner)
                            ->get();

        return view('partner.detail')
                ->withPartner($partnerData)
                ->withProdottiAssociatiList($prodottiAssociatiList)
                ->withOrdini($ordini);
    }

    /**
     * Eliminazione logica del partner
     */
    public function delete($idPartner){
        Partner::where('external_id', $idPartner)->delete();

        return redirect()
                ->route('showPartner')
                ->with('danger', 'Partner eliminato con successo');
    }

    /**
     * Ritorna la view con i dati del listino associato ad un partner
     */
    public function listinoPartner($idPartner, $idProdottoAssociato = null){
        //recupero i prodotti associati al partner
        $prodottiAssociatiList = ProdottiPartner::select('prodotti_partner.id AS id_associazione', 'prodotti.titolo AS nome_prodotto', 'prezzo', 'prodotti_partner.prodotto_id AS prodotto')
                                                    ->join('prodotti', 'prodotti_partner.prodotto_id', '=', 'prodotti.external_id')
                                                    ->where('prodotti_partner.partner_id', $idPartner)
                                                    ->whereNull('prodotti_partner.deleted_at')
                                                    ->get();

        //recupero i dati del partner
        $partnerData = Partner::select('titolo', 'external_id')
                                ->where('external_id', $idPartner)->first();

        $prodottoAssociatoData = null;
        if(isset($idProdottoAssociato)){
            $prodottoAssociatoData = ProdottiPartner::where('id', $idProdottoAssociato)->first();
        }else{
            $prodottoAssociatoData = null;
        }

        //recupero tutti i prodotti
        $prodottiList = Prodotti::pluck('titolo', 'external_id');

        return view('partner.listino')
                ->withProdottiList($prodottiList)
                ->withPartnerData($partnerData)
                ->withProdottoAssociato($prodottoAssociatoData)
                ->withProdottiAssociatiList($prodottiAssociatiList);
    }

    /**
     * Associa il prodotto al partner
     */
    public function createListino(Request $request){
        //vlaidazione
        if(isset($request->id_prod_assoc)){
            $validator = Validator::make($request->all(), [
                'prodotto_id' => ['required'],
                'prezzo' => ['required', 'numeric']
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'prodotto_id' => ['required', 
                               Rule::unique('prodotti_partner')->where('partner_id', $request->ext_id_partner)->whereNull('deleted_at')
                            ],
                'prezzo' => ['required', 'numeric']
            ]);
        }

        if($validator->fails()){

            return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
        }

        try{
            $prodottiPartner = ProdottiPartner::updateOrCreate(
                [ 
                    'partner_id' => $request->ext_id_partner, 
                    'prodotto_id' => $request->prodotto_id
                ],
                [
                    'prezzo' => $request->prezzo
                ]
            );

            if($prodottiPartner->wasRecentlyCreated){
                return redirect()
                        ->route('listino', $request->ext_id_partner)
                        ->with('success', 'Prodotto associato con successo');
            }else{
                return redirect()
                        ->route('listino', $request->ext_id_partner)
                        ->with('warning', 'Partner associato aggiornato con successo');
            }

        }catch(QueryException $ex){
            return redirect()
                    ->back()
                    ->withInput()
                    ->with('danger_inserimento', "Errore durante l'associazione di un prodotto".$ex->getMessage());
        }
    }

    public function deleteAssociazioneProdotto($idPartner, $idAssociazione){
        ProdottiPartner::where('id', $idAssociazione)->delete();

        return redirect()
                ->route('listino', ['idPartner' => $idPartner])
                ->with('danger', 'Associazione prodotto eliminata con successo');
    }
}
