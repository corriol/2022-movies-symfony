//import $ from 'jquery';
let $ = require("jquery");
require ('bootstrap');
require('cropperjs');

let Cropper = require("../public/bundles/prestaimage/js/cropper");


//import * as Cropper from 'prestaimage/js/cropper';

import "../public/bundles/prestaimage/css/cropper.css";

//require("cropper/dist/cropper.min.css");
require("cropperjs/dist/cropper.min.css");
require("bootstrap/dist/css/bootstrap.css");




$(function() {
    $('.cropper').each(function() {
        new Cropper($(this), true);
    });
});