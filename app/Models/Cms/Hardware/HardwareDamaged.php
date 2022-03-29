<?php

namespace App\Models\Cms\Hardware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Inventory\InventoryNewProduct;

class HardwareDamaged extends Model
{
    use HasFactory;

    public function makby(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function complain(){
        return $this->hasOne('App\Models\Cms\Hardware\HardwareComplain', 'id', 'comp_id');
    }

    public function sing_product(){
        return $this->hasOne('App\Models\Inventory\InventoryNewProduct', 'id', 'rep_pro_id');
    }

    //public function product(){

        //return InventoryNewProduct::where('id', [231, 232]);

        // return $this->hasMany('App\Models\Inventory\InventoryNewProduct')->wherePivotIn('id', [231, 232]);

        // dd('model ok', $this->id);

        // $data = Parent::has('sing_product')->with(['sing_product' => function($query){
        //     $query->where(); //you may use any condition here or manual select operation
        //     $query->select(); //select operation
        // }])
        // ->get();

        // return $query
        //       ->when($this->type === 'agents',function($q){
        //           return $q->with('agentProfile');
        //      })
        //      ->when($this->type === 'school',function($q){
        //           return $q->with('schoolProfile');
        //      })
        //      ->when($this->type === 'academy',function($q){
        //           return $q->with('academyProfile');
        //      },function($q){
        //          return $q->with('institutionProfile');
        //      });
    //}


    //Relation user to role
    public function replace_product()
    {
        return $this->belongsToMany('App\Models\Inventory\InventoryNewProduct', 'hardware_damaged_rep_pro');
    }
 



    public function scopeSearch($query, $val='')
    {
        return $query
        ->where('comp_id', 'LIKE', '%'.$val.'%')
        ->where('damaged_type', 'LIKE', '%'.$val.'%')
        ->where('applicable_type', 'LIKE', '%'.$val.'%')
        ->orWhere('damaged_reason', 'LIKE', '%'.$val.'%')
        ->orWhere('rec_name', 'LIKE', '%'.$val.'%')
        ->orWhere('rec_contact', 'LIKE', '%'.$val.'%')
        ->orWhere('rec_position', 'LIKE', '%'.$val.'%')
        ->orWhereHas('makby', function($query) use ($val){
            $query->WhereRaw('login LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('complain.makby', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('complain.makby', function($query) use ($val){
            $query->WhereRaw('department LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('complain.category', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        })
        ->orWhereHas('complain.subcategory', function($query) use ($val){
            $query->WhereRaw('name LIKE ?', '%'.$val.'%');
        });
        // ->orWhereHas('product', function($query) use ($val){
        //     $query->WhereRaw('name LIKE ?', '%'.$val.'%')
        //     ->WhereRaw('serial LIKE ?', '%'.$val.'%')
        //     ->WhereRaw('invoice_num LIKE ?', '%'.$val.'%')
        //     ->WhereRaw('po_number LIKE ?', '%'.$val.'%');
        // }); 
    }
}
