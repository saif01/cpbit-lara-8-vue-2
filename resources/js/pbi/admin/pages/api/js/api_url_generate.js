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

        // Food 
        else if(val == 'PbiFoodFurtherSale')
        {
            return 'food-further-sales'
        }
        else if(val == 'PbiFoodSlaughterSale')
        {
            return 'food-slaughter-sales'
        }

        
        // Feed 
        else if(val == 'PbiFeedProduction')
        {
            return 'feed-production'
        }
        else if(val == 'PbiFeedPurchase')
        {
            return 'feed-purchase'
        }
        else if(val == 'PbiFeedSale')
        {
            return 'feed-sales'
        }

        else if(val == 'PbiExpense')
        {
            return 'expense'
        }

        
    }
}