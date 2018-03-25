
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// ES2015 import
import $ from 'jquery';
import 'popper.js';
import 'bootstrap';

import dt from 'datatables.net-bs4';

/**
 *  Expose jQuery to window object
 */
window.jQuery = window.$ = $;


/* ---- DATATABLE ---- */
import fixedheader from 'datatables.net-fixedheader';
import moment from 'moment';
(function (factory) {
    if (typeof define === "function" && define.amd) {
        define(["jquery", "moment", "datatables.net"], factory);
    } else {
        factory(jQuery, moment);
    }
}(function ($, moment) {
 
$.fn.dataTable.moment = function ( format, locale ) {
    var types = $.fn.dataTable.ext.type;
 
    // Add type detection
    types.detect.unshift( function ( d ) {
        if ( d ) {
            // Strip HTML tags and newline characters if possible
            if ( d.replace ) {
                d = d.replace(/(<.*?>)|(\r?\n|\r)/g, '');
            }
 
            // Strip out surrounding white space
            d = $.trim( d );
        }
 
        // Null and empty values are acceptable
        if ( d === '' || d === null ) {
            return 'moment-'+format;
        }
 
        return moment( d, format, locale, true ).isValid() ?
            'moment-'+format :
            null;
    } );
 
    // Add sorting method - use an integer for the sorting
    types.order[ 'moment-'+format+'-pre' ] = function ( d ) {
        if ( d ) {
            // Strip HTML tags and newline characters if possible
            if ( d.replace ) {
                d = d.replace(/(<.*?>)|(\r?\n|\r)/g, '');
            }
 
            // Strip out surrounding white space
            d = $.trim( d );
        }
         
        return !moment(d, format, locale, true).isValid() ?
            Infinity :
            parseInt( moment( d, format, locale, true ).format( 'x' ), 10 );
    };
};
 
}));

import dtConfig from './dtConfig.js';
$(document).ready(function() {
    $.fn.dataTable.moment( 'dd/MM/YYYY HH:mm' );
    $.fn.dataTable.moment( 'dd/MM/YYYY' );
    $('table.DataTable').DataTable(dtConfig);
} );