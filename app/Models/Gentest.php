<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gentest extends Model
{
    use HasFactory;

    protected $table = 'gentests';

    protected $fillable = ['id', 'hund_id', 'datum', 'datum_blutentnahme', 'arzt_id', 'arzt_titel', 'arzt_vorname', 'arzt_nachname', 'arzt_praxis', 'arzt_strasse', 'arzt_plz', 'arzt_ort', 'arzt_land', 'arzt_land_kuerzel', 'arzt_email', 'arzt_website', 'arzt_telefon_1', 'arzt_telefon_2', 'bemerkungen', 'dokument_id', 'dokumentable_id', 'dokumentable_type', 'dna_labor_id', 'dna_labor_name', 'dna_profil', 'pra_test_id', 'pra_prcd_gentest_id', 'cnm_gentest_id', 'eic_gentest_id', 'dm_gentest_id', 'sd2_gentest_id', 'narc_gentest_id', 'rd_osd_gentest_id', 'cea_ch_gentest_id', 'gr_pra1_gentest_id', 'gr_pra2_gentest_id', 'haarlaenge_id', 'gsdiiia_gentest_id', 'grmd_gentest_id', 'ict_a_gentest_id', 'ed_sfs_gentest_id', 'hnpk_gentest_id', 'ncl5_gentest_id', 'ncl_f_gentest_id', 'farbtest_gelb_id', 'farbtest_braun_id', 'farbverduennung_id', 'den_gentest_id', 'ict_2_gentest_id', 'jadd_gentest_id', 'cp1_gentest_id', 'cps_gentest_id', 'clps_gentest_id', 'ivdd_gentest_id', 'cms_gentest_id', 'dann_farbtest_id', 'dil_gentest_id', 'mh_gentest_id', 'cddy_gentest_id', 'cdpa_gentest_id', 'huu_gentest_id', 'deb_gentest_id', 'buff_gentest_id', 'dil_gentest_id', 'md_gentest_id', 'cord1_pra_gentest_id', 'glasknochen_gentest_id', 'stgd_gentest_id', 'oi_gentest_id'];

    protected $append = ['dokumente'];
    //  protected $appends = [ 'pra_test','pra_prcd','cnm','eic','dm','sd2','narc','rd_osd','cea_ch','gr_pra1','gr_pra2','haarlaenge','gsdiiia','grmd','ict_a','ed_sfs','hnpk','ncl5','ncl_f','farbtest_gelb','farbtest_braun','farbverduennung','den','ict_2','jadd','cp1','cps','clps','ivdd','cms','dil','mh','cddy','cdpa','huu','deb','buff','dil','md','cord1_pra','glasknochen','stgd','oi'];

    public function scopeAktiv($query)
    {
        return $query->where('aktiv', true);
    }

    public function hund()
    {
        return $this->belongsTo(Hund::class);
    }

    public function status()
    {
        return $this->belongsTo(OptionAntragStatus::class, 'status_id')->withDefault([
            'id' => 0,
            'name' => 'Bitte auswählen',
        ]);
    }

    public function dokumente()
    {
        return $this->morphToMany(Dokument::class, 'dokumentable')->orderBy('updated_at', 'asc');
    }

    public function sd2_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'sd2_gentest_id');
    }

    public function getSD2Attribute()
    {
        return $this->sd2_gentest_id ? $this->sd2_option->name : '';
    }

    public function cnm_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'cnm_gentest_id');
    }

    public function getCNMAttribute()
    {
        return $this->cnm_gentest_id ? $this->cnm_option->name : '';
    }

    public function pra_test_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'pra_test_id');
    }

    public function getPraTestAttribute()
    {
        return $this->pra_test_id ? $this->pra_test_option->name : '';
    }

    public function pra_prcd_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'pra_prcd_gentest_id');
    }

    public function getPraPrcdAttribute()
    {
        return $this->pra_prcd_gentest_id ? $this->pra_prcd_option->name : '';
    }

    public function eic_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'eic_gentest_id');
    }

    public function getEicAttribute()
    {
        return $this->eic_gentest_id ? $this->eic_option->name : '';
    }

    public function dm_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'dm_gentest_id');
    }

    public function getDmAttribute()
    {
        return $this->dm_gentest_id ? $this->dm_option->name : '';
    }

    public function narc_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'narc_gentest_id');
    }

    public function getNarcAttribute()
    {
        return $this->narc_gentest_id ? $this->narc_option->name : '';
    }

    public function rd_osd_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'rd_osd_gentest_id');
    }

    public function getRdOsdAttribute()
    {
        return $this->rd_osd_gentest_id ? $this->rd_osd_option->name : '';
    }

    public function cea_ch_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'cea_ch_gentest_id');
    }

    public function getCeaChAttribute()
    {
        return $this->cea_ch_gentest_id ? $this->cea_ch_option->name : '';
    }

    public function gr_pra1_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'gr_pra1_gentest_id');
    }

    public function getGrPra1Attribute()
    {
        return $this->gr_pra1_gentest_id ? $this->gr_pra1_option->name : '';
    }

    public function gr_pra2_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'gr_pra2_gentest_id');
    }

    public function getGrPra2Attribute()
    {
        return $this->gr_pra2_gentest_id ? $this->gr_pra2_option->name : '';
    }

    public function haarlaenge_option()
    {
        return $this->belongsTo(OptionGentestHaarlaenge::class, 'haarlaenge_id');
    }

    public function getHaarlaengeAttribute()
    {
        return $this->haarlaenge_id ? $this->haarlaenge_option->name : '';
    }

    public function gsdiiia_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'gsdiiia_gentest_id');
    }

    public function getGsdiiiaAttribute()
    {
        return $this->gsdiiia_gentest_id ? $this->gsdiiia_option->name : '';
    }

    public function grmd_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'grmd_gentest_id');
    }

    public function getGrmdAttribute()
    {
        return $this->grmd_gentest_id ? $this->grmd_option->name : '';
    }

    public function ict_a_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'ict_a_gentest_id');
    }

    public function getIctAAttribute()
    {
        return $this->ict_a_gentest_id ? $this->ict_a_option->name : '';
    }

    public function ed_sfs_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'ed_sfs_gentest_id');
    }

    public function getEdSfsAttribute()
    {
        return $this->ed_sfs_gentest_id ? $this->ed_sfs_option->name : '';
    }

    public function hnpk_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'hnpk_gentest_id');
    }

    public function getHnpkAttribute()
    {
        return $this->hnpk_gentest_id ? $this->hnpk_option->name : '';
    }

    public function ncl5_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'ncl5_gentest_id');
    }

    public function getNcl5Attribute()
    {
        return $this->ncl5_gentest_id ? $this->ncl5_option->name : '';
    }

    public function ncl_f_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'ncl_f_gentest_id');
    }

    public function getNclFAttribute()
    {
        return $this->ncl_f_gentest_id ? $this->ncl_f_option->name : '';
    }

    public function farbtest_gelb_option()
    {
        return $this->belongsTo(OptionGentestFarbeGelb::class, 'farbtest_gelb_id');
    }

    public function getFarbtestGelbAttribute()
    {
        return $this->farbtest_gelb_id ? $this->farbtest_gelb_option->name : '';
    }

    public function farbtest_braun_option()
    {
        return $this->belongsTo(OptionGentestFarbeBraun::class, 'farbtest_braun_id');
    }

    public function getFarbtestBraunAttribute()
    {
        return $this->farbtest_braun_id ? $this->farbtest_braun_option->name : '';
    }

    public function farbverduennung_option()
    {
        return $this->belongsTo(OptionGentestFarbverduennung::class, 'farbverduennung_id');
    }

    public function getFarbverduennungAttribute()
    {
        return $this->farbverduennung_id ? $this->farbverduennung_option->name : '';
    }

    public function den_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'den_gentest_id');
    }

    public function getDenAttribute()
    {
        return $this->den_id ? $this->den_option->name : '';
    }

    public function ict_2_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'ict_2_gentest_id');
    }

    public function getIct2Attribute()
    {
        return $this->ict_2_gentest_id ? $this->ict_2_option->name : '';
    }

    public function jadd_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'jadd_gentest_id');
    }

    public function getJaddAttribute()
    {
        return $this->jadd_gentest_id ? $this->jadd_option->name : '';
    }

    public function cp1_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'cp1_gentest_id');
    }

    public function getCp1Attribute()
    {
        return $this->cp1_gentest_id ? $this->cp1_option->name : '';
    }

    public function cps_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'cps_gentest_id');
    }

    public function getCpsAttribute()
    {
        return $this->cps_gentest_id ? $this->cps_option->name : '';
    }

    public function clps_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'clps_gentest_id');
    }

    public function getClpsAttribute()
    {
        return $this->clps_gentest_id ? $this->clps_option->name : '';
    }

    public function ivdd_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'ivdd_gentest_id');
    }

    public function getIvddAttribute()
    {
        return $this->ivdd_gentest_id ? $this->ivdd_option->name : '';
    }

    public function cms_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'cms_gentest_id');
    }

    public function getCmsAttribute()
    {
        return $this->cms_gentest_id ? $this->cms_option->name : '';
    }

    public function mh_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'mh_gentest_id');
    }

    public function getMhAttribute()
    {
        return $this->mh_gentest_id ? $this->mh_option->name : '';
    }

    public function cddy_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'cddy_gentest_id');
    }

    public function getCddyAttribute()
    {
        return $this->cddy_gentest_id ? $this->cddy_option->name : '';
    }

    public function cdpa_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'cdpa_gentest_id');
    }

    public function getCdpaAttribute()
    {
        return $this->cdpa_gentest_id ? $this->cdpa_option->name : '';
    }

    public function huu_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'huu_gentest_id');
    }

    public function getHuuAttribute()
    {
        return $this->huu_gentest_id ? $this->huu_option->name : '';
    }

    public function deb_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'deb_gentest_id');
    }

    public function getDebAttribute()
    {
        return $this->deb_gentest_id ? $this->deb_option->name : '';
    }

    public function buff_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'buff_gentest_id');
    }

    public function getBuffAttribute()
    {
        return $this->buff_gentest_id ? $this->buff_option->name : '';
    }

    public function dil_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'dil_gentest_id');
    }

    public function getDilAttribute()
    {
        return $this->dil_gentest_id ? $this->dil_option->name : '';
    }

    public function md_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'md_gentest_id');
    }

    public function getMdAttribute()
    {
        return $this->md_gentest_id ? $this->md_option->name : '';
    }

    public function cord1_pra_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'cord1_pra_gentest_id');
    }

    public function getCord1PraAttribute()
    {
        return $this->cord1_pra_gentest_id ? $this->cord1_pra_option->name : '';
    }

    public function glasknochen_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'glasknochen_gentest_id');
    }

    public function getGlasknochenAttribute()
    {
        return $this->glasknochen_gentest_id ? $this->glasknochen_option->name : '';
    }

    public function stgd_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'stgd_gentest_id');
    }

    public function getStgdAttribute()
    {
        return $this->stgd_gentest_id ? $this->stgd_option->name : '';
    }

    public function oi_option()
    {
        return $this->belongsTo(OptionGentestStd::class, 'oi_gentest_id');
    }

    public function getOiAttribute()
    {
        return $this->oi_gentest_id ? $this->oi_option->name : '';
    }

    //  public function getCnmAttribute()
    //  {
    //    return $this->belongsTo(OptionGentestStd::class, 'cnm_gentest_id')->name();
    //  }

}
