
// inputs
import inputFilterUsername from './inputs/input-filter-username.js';
import inputFilterWebsite from './inputs/input-filter-website.js';
import inputFilterDescription from './inputs/input-filter-description.js';
import inputFilterNote from './inputs/input-filter-note.js';

// selects
import selectFilterCategory from './selects/select-category.js';

// buttons
import buttonSearchFilters from './buttons/button-search-filters.js';
import buttonClearFilters from './buttons/button-clear-filters.js';

// tables
import Tbl_Passwords from '../tables/Tbl_Passwords.js';

// data
import Data_Passwords from '../data/Data_Passwords.js';

class Search {
    constructor() {}

    /**
     * perform search
     */
    performSearch() {
        // disable search button
        buttonSearchFilters.enabled(false)

        const filterUsername = inputFilterUsername.valueGet()
        const filterCategoryId = selectFilterCategory.get_selected_value()
        const filterWebsite = inputFilterWebsite.valueGet()
        const filterDescription = inputFilterDescription.valueGet()
        const filterNote = inputFilterNote.valueGet()

        const allPasswords = Data_Passwords.dataGet()

        // search in all passwords by filters
        let filteredPasswords = allPasswords;

        if (filterUsername !== undefined) {
            filteredPasswords = filteredPasswords.filter((password) => {
                return password['username'].toLowerCase().includes(filterUsername.toLowerCase());
            });
        }
        if (filterCategoryId !== undefined) {
            filteredPasswords = filteredPasswords.filter((password) => {
                return password['category_id'] == filterCategoryId;
            });
        }
        if (filterWebsite !== undefined) {
            filteredPasswords = filteredPasswords.filter((password) => {
                return password['website'].toLowerCase().includes(filterWebsite.toLowerCase());
            });
        }
        if (filterDescription !== undefined) {
            filteredPasswords = filteredPasswords.filter((password) => {
                return password['description'].toLowerCase().includes(filterDescription.toLowerCase());
            });
        }
        if (filterNote !== undefined) {
            filteredPasswords = filteredPasswords.filter((password) => {
                return password['note'].toLowerCase().includes(filterNote.toLowerCase());
            });
        }


        // clear table
        Tbl_Passwords.clearRows()

        if (filteredPasswords.length) {
            // add passwords to table
            filteredPasswords.forEach(filteredPassword => {
                Tbl_Passwords.rowAdd(filteredPassword)
            })
        }
        else {
            // show no results
            Tbl_Passwords.showNoResultsRow()
        }

        // enable search button
        buttonSearchFilters.enabled(true)
    }

    /**
     * clear filters and add back all passwords to table
     * @return {void}
     */
    clearFilters() {
        // clear fields
        inputFilterUsername.valueClear()
        selectFilterCategory.deselect()
        inputFilterWebsite.valueClear()
        inputFilterDescription.valueClear()
        inputFilterNote.valueClear()

        // clear table rows
        Tbl_Passwords.clearRows()

        // add back all passwords to table
        const allPasswords = Data_Passwords.dataGet()
        allPasswords.forEach(filteredPassword => {
            Tbl_Passwords.rowAdd(filteredPassword)
        })
    }


    /**
     * put categories into filter categories
     * @param _categories {array}
     *
     * example of _categories:<br>
     * [<br>
     *     {"id": "0", "name": "Friends"}<br>
     * ]<br>
     */
    putCategoriesIntoSelect(_categories) {
        selectFilterCategory.put_options(_categories, 'id', 'name')
    }
}

export default new Search()