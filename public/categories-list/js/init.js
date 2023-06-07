// data
import Data_Categories from './data/Data_Categories.js';

// tables
import Tbl_Categories from './tables/Tbl_Categories.js';

async function prepareCategoriesTable() {
    // get user categories
    await Data_Categories.fetchCategories()

    // get fetched categories
    const fetchedCategories = Data_Categories.dataGet()

    // check if categories found
    if (fetchedCategories.length) {
        for (const fetchedCategory of fetchedCategories) {
            Tbl_Categories.rowAdd(fetchedCategory)
        }
    } else {
        Tbl_Categories.showNoResultsRow()
    }
}

await prepareCategoriesTable()

$('.loader-wrapper').fadeOut('slow', function() {
    $(this).remove();
});