export default{
    apiUrlGenerate(val){
        if(val == 'PbiFarmAquaSale')
        {
           return 'farm-aqua-sales'
        }

        else if(val == 'PbiFarmAquaPurchase')
        {
            return 'farm-aqua-purchase'
        }

        else if(val == 'PbiFarmPoultrySale')
        {
            return 'farm-poultry-sales'
        }
    }
}