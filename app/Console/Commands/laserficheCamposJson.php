<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class laserficheCamposJson extends Command
{

    protected $signature = 'laser:campos-json';

    protected $description = 'Actializa el campo prop_def de la tabla "fenasis_laserfiche_documents" tomando las realciones de campos configuradas en otras tablas.';

    public function handle()
    {

        /** Metodo 3 optimizado por chatGPT */

        // $chunkSize = 1000;

        // DB::table('fenasis_laserfiche_documents AS doc')
        //     ->join('propset AS ps', 'doc.pset_id', '=', 'ps.pset_id')
        //     ->join('propval AS pv', 'doc.tocid', '=', 'pv.tocid')
        //     ->join('propdef AS pd', 'pv.prop_id', '=', 'pd.prop_id')
        //     ->select(
        //         'doc.tocid',
        //         'ps.pset_id AS id_plantilla',
        //         'ps.pset_name AS name_plantilla',
        //         DB::raw('json_arrayagg(json_object(
        //     "id_campo", pv.prop_id,
        //     "name_campo", pd.prop_name,
        //     "pos", pv.pos,
        //     "value", pv.str_val
        // )) AS campos')
        //     )
        //     ->whereNotNull('doc.pset_id')
        //     ->whereNull('doc.prop_def')
        //     ->orderBy('doc.tocid')
        //     ->groupBy('doc.tocid', 'ps.pset_id', 'ps.pset_name')
        //     ->chunk($chunkSize, function ($values) {
        //         foreach ($values as $key => $doc) {
        //             $campos = json_decode($doc->campos, true);
        //             $prop_def = json_encode([
        //                 [
        //                     'tocid' => $doc->tocid,
        //                     'id_plantilla' => $doc->id_plantilla,
        //                     'name_plantilla' => $doc->name_plantilla,
        //                     'fields_plantilla' => $campos,
        //                 ],
        //             ]);
        //             DB::table('fenasis_laserfiche_documents')
        //                 ->where('tocid', $doc->tocid)
        //                 ->update(['prop_def' => $prop_def]);
        //         }
        //     });

        /** Metodo 2 optimizado por chatGPT */

        // $chunkSize = 1000;

        // DB::table('fenasis_laserfiche_documents')
        //     ->orderBy('id')
        //     ->whereNotNull('pset_id')
        //     ->whereNull('prop_def')
        //     ->chunk($chunkSize, function ($documents) {
        //         foreach ($documents as $document) {
        //             $fields = DB::table('propval')
        //                 ->join('propdef', 'propval.prop_id', '=', 'propdef.prop_id')
        //                 ->select('propval.*', 'propdef.prop_name')
        //                 ->where('tocid', $document->tocid)
        //                 ->get()
        //                 ->map(function ($field) {
        //                     return [
        //                         'id_campo' => $field->prop_id,
        //                         'name_campo' => $field->prop_name,
        //                         'pos' => $field->pos,
        //                         'value' => $field->str_val,
        //                     ];
        //                 })
        //                 ->toArray();

        //             $propDef = [
        //                 'tocid' => $document->tocid,
        //                 'id_plantilla' => $document->pset_id,
        //                 'name_plantilla' => DB::table('propset')
        //                     ->where('pset_id', $document->pset_id)
        //                     ->value('pset_name'),
        //                 'fields_plantilla' => $fields,
        //             ];

        //             DB::table('fenasis_laserfiche_documents')
        //                 ->where('tocid', $document->tocid)
        //                 ->update([
        //                     'prop_def' => json_encode([$propDef]),
        //                 ]);
        //         }
        //     });

        // $this->info('Fin de la Actualizacion de documentos');

        /** Metodo uno creado por renier */

        $chunkSize = 1000;

        /** CONSULTO LOS DOCUMENTOS */
        $documentos = DB::table('fenasis_laserfiche_documents')->orderBy('id')->whereNotNull('pset_id')->whereNull('prop_def')->chunk($chunkSize, function ($values) {

            $bar = $this->output->createProgressBar(count($values));
            $bar->start();
            /** RECORRO LOS DOCUMENTOS POR LOTES PARA ACTUALIZARLOS EN CHUNKS */
            foreach ($values as $key => $doc) {
                $arr_json = [];
                /** OBTENGO LA PLANTILLA QUE VA RELACIONADA CON EL DOCUMENTO */
                $plantilla = DB::table('propset')->select('pset_name', 'pset_id')->where('pset_id', $doc->pset_id)->first();

                /** OBTENGO LOS CAMPOS Y EL CONTENIDO RELACIONADOS CON EL DOCUMENTO Y LA PLANTILLA
                 * TRANSFORMO EL RESULTADO PARA OBTENER SOLO LOS DATOS NECESARIOS
                 */
                $campos = DB::table('propval')
                    ->join('propdef', 'propval.prop_id', '=', 'propdef.prop_id')
                    ->select('propval.*', 'propdef.prop_name')
                    ->where('tocid', $doc->tocid)
                    ->get()->transform(function ($val) {
                    $data = [];
                    $data['id_campo'] = $val->prop_id;
                    $data['name_campo'] = $val->prop_name;
                    $data['pos'] = $val->pos;
                    $data['value'] = $val->str_val;
                    return $data;
                })->toArray();

                /** CARGO UN ARRELO CON LOS DATOS QUE POSTERIORMENTE SERA CONVERTIDOS EN UN JSON. */
                array_push($arr_json, [
                    'tocid' => $doc->tocid,
                    'id_plantilla' => $plantilla->pset_id,
                    'name_plantilla' => $plantilla->pset_name,
                    'fields_plantilla' => $campos,
                ]);

                /** ACTUALIZO EL CADA DOCUMENTO CON EL CAMPO PROP_DEF EN FORMATO JSON */
                DB::table('fenasis_laserfiche_documents')->where('tocid', $doc->tocid)->update([
                    'prop_def' => json_encode($arr_json),
                ]);

                $bar->advance();
            }
            $bar->finish();
        });

        $this->info('Fin de la Actualizacion de documentos');

    }
}
