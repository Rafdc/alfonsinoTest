<?php

namespace App\Http\Controllers;

use App\Models\Prodotti;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\DataTables;

class ProdottiController extends Controller
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
     * Mostra tutti i prodotti
     */
    public function show(){
        if(request()->ajax()) {
            $prodottiList = Prodotti::select('external_id', 'titolo', 'foto')
                                    ->whereNull('deleted_at');

            return DataTables::of($prodottiList)
                                ->editColumn('action', function($row){
                                    $btn =  '<a href="'.route('formProdotto', $row->external_id).'" data-toggle="tooltip" data-placement="top" title="Modifica"><i class="fa fa-edit text-warning mr-3"></i></a>'.  
                                            '<a href="'.route('deleteProdotto', $row->external_id).'" onclick="return confirm(\'Procedere con la cancellazione del prodotto?\')" data-toggle="tooltip" data-placement="top" title="Elimina"><i class="fa fa-trash text-danger"></i></a>';
                                    return $btn;
                                })
                                ->addColumn('foto', function($row){
                                    if($row->foto != ""){
                                        if(Storage::exists($row->foto)){
                                            $url = Storage::url($row->foto);
                                            return '<img src="'.$url.'" border="0" width="60" class="img-rounded "/>';
                                        }else{
                                            return "Immagine non trovata";
                                        }
                                    }else{
                                        return "Nessuna immagine inserita";
                                    }
                                })
                                ->rawColumns(['foto', 'action'])
                                ->make(true);
        }
        return view('prodotti.show');
    }
    /**
     * Mostra il form per la creazione di un prodotto, se idProdotto non è nullo, recupera i dati di quel prodotto
     */
    public function formProdotto($idProdotto = null){
        $prodottoData = null;

        if(isset($idProdotto)){
            $prodottoData = Prodotti::where('external_id', $idProdotto)->first();
        }

        return view('prodotti.form')
                ->withProdottoData($prodottoData);
    }

    /**
     * Crea o modifica un prodotto
     */
    public function addUpdateProdoto(Request $request){
        //validazione
        $validator = Validator::make($request->all(), [
            'titolo' => ['required', Rule::unique('prodotti')->ignore($request->ext_id, 'external_id')],
            'image' => ['mimes:jpg,jpeg,png', 'max:5000']
        ]);

        if($validator->fails()){
            return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator);
        }

        $path = generateFilePath($request->path_image, $request->file('image'), 'prodotto');

        $uuid = generateUuid($request->ext_id);

        try{
            $prodotto = Prodotti::updateOrCreate(
                [ 'external_id' => $uuid ],
                [
                    'titolo' => $request->titolo,
                    'foto' => $path
                ]
            );

            if($prodotto->wasRecentlyCreated){
                return redirect()
                        ->route('showProdotti')
                        ->with('success', 'Prodotto creato con successo');
            }else{
                return redirect()
                        ->route('showProdotti')
                        ->with('warning', 'Prodotto aggiornato con successo');
            }

        }catch(QueryException $ex){
            return redirect()
                    ->back()
                    ->withInput()
                    ->with('danger', "Errore durante l'inserimento di un prodotto");
        }
    }

    /**
     * Eliminazione logica del prodotto
     */
    public function delete($idProdotto){
        Prodotti::where('external_id', $idProdotto)->delete();

        return redirect()
                ->route('showProdotti')
                ->with('danger', 'Prodotto eliminato con successo');
    }
}
