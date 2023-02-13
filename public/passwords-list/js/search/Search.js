
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

        // search in all passwords by filters
        const allPasswords = Data_Passwords.dataGet()
        let filteredPasswords = allPasswords;
        let filterApplied = false // this is used to show button to clear filters if any filter is applied

        if (filterUsername !== undefined) {
            filterApplied = true
            filteredPasswords = filteredPasswords.filter((password) => {
                return password['username'].toLowerCase().includes(filterUsername.toLowerCase());
            });
        }
        if (filterCategoryId !== undefined) {
            filterApplied = true
            filteredPasswords = filteredPasswords.filter((password) => {
                return password['category_id'] == filterCategoryId;
            });
        }
        if (filterWebsite !== undefined) {
            filterApplied = true
            filteredPasswords = filteredPasswords.filter((password) => {
                return password['website'].toLowerCase().includes(filterWebsite.toLowerCase());
            });
        }
        if (filterDescription !== undefined) {
            filterApplied = true
            filteredPasswords = filteredPasswords.filter((password) => {
                return password['description'].toLowerCase().includes(filterDescription.toLowerCase());
            });
        }
        if (filterNote !== undefined) {
            filterApplied = true
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

        // show clear filters button if filter applied
        if (filterApplied) buttonClearFilters.shown(true)

        // enable search button
        buttonSearchFilters.enabled(true)
    }

    /**
     * clear filters and add back all passwords to table
     * @return {void}
     */
    clearFilters() {
        // hide clear filters button
        buttonClearFilters.shown(false)

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