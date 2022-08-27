<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Ordini as ResourcesOrdini;
use App\Http\Resources\PartnerProdotti;
use App\Models\DettaglioOrdine;
use App\Models\Ordini;
use App\Models\ProdottiPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdiniController extends BaseController
{
    public function getProdotti($idPartner = null){
        if(isset($idPartner)){
            $prodottiPartner = ProdottiPartner::select('prodotti_partner.id AS id_associazione', 'prodotti.titolo AS prodotto', 'prezzo', 'partner.titolo AS partner')
                                                    ->join('prodotti', 'prodotti_partner.prodotto_id', '=', 'prodotti.external_id')
                                                    ->join('partner', 'prodotti_partner.partner_id', '=', 'partner.external_id')
                                                    ->where('prodotti_partner.partner_id', $idPartner)
                                                    ->whereNull('prodotti_partner.deleted_at')
                                                    ->get();
        }else{
            $prodottiPartner = ProdottiPartner::select('prodotti_partner.id AS id_associazione', 'prodotti.titolo AS prodotto', 'prezzo', 'partner.titolo AS partner')
                                                    ->join('prodotti', 'prodotti_partner.prodotto_id', '=', 'prodotti.external_id')
                                                    ->join('partner', 'prodotti_partner.partner_id', '=', 'partner.external_id')
                                                    ->whereNull('prodotti_partner.deleted_at')
                                                    ->get();
        }
        

        return $this->handleResponse(PartnerProdotti::collection($prodottiPartner), 'Lista partner con relativi prodotti ricevuta');
    }

    /**
     * Recupera gli ordini dell'utente
     */
    public function showOrdini(){
        $ordini = Ordini::select('ordini.id', 'partner.titolo AS partner', 'totale')
                            ->join('partner', 'partner.external_id', '=', 'ordini.id_partner')
                            ->where('id_cliente', auth()->user()->id)
                            ->whereNull('ordini.deleted_at')
                            ->get();

        return $this->handleResponse(ResourcesOrdini::collection($ordini), 'Ordini effettuati');
    }

    /**
     * Crea un ordine
     */
    public function createOrdine(Request $request){
        $totale = 0;
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'id_partner' => 'required'
        ]);

        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }

        //calcolo il totale dei prodotti selezionati
        foreach($request->prodotto as $singleProdotto){
            $totale += ProdottiPartner::select('prezzo')
                                ->where('partner_id', $input['id_partner'])
                                ->where('prodotto_id', $singleProdotto)
                                ->first()->prezzo;

        }

        //salvo i dati dell'ordine nella tabella ordini
        $ordine = Ordini::create([
            'id_cliente' => auth()->user()->id,
            'id_partner' => $input['id_partner'],
            'totale' => $totale
        ]);

        //salvo i dettagli dell'ordine cioè i prodotti specifici dell'ordine nella tabella dettaglio_ordine
        foreach($request->prodotto as $singleProd){
            DettaglioOrdine::create([
                'id_prodotto' => $singleProd,
                'id_ordine' => $ordine->id
            ]);
        }

        return $this->handleResponse(new OrdiniController($ordine), 'Ordine creato con successo');
    }

    /**
     * Elimina un ordine e le righe associate nel dettaglio
     */
    public function deleteOrdine($idOrdine){
        Ordini::where('id', $idOrdine)->delete();

        DettaglioOrdine::where('id_ordine', $idOrdine)->delete();

        return $this->handleResponse([], 'Ordine Eliminato');
    }
}
