import 'package:flutter/material.dart';

///
/// ps_static static constants.dart
/// ----------------------------
/// Developed by Panacea-Soft
/// www.panacea-soft.com
///

import 'package:fluttermultigrocery/config/ps_config.dart';
import 'package:intl/intl.dart';

class PsConst {
  PsConst._();

  static const String THEME__IS_DARK_THEME = 'THEME__IS_DARK_THEME';

  static const String LANGUAGE__LANGUAGE_CODE_KEY =
      'LANGUAGE__LANGUAGE_CODE_KEY';
  static const String LANGUAGE__COUNTRY_CODE_KEY = 'LANGUAGE__COUNTRY_CODE_KEY';
  static const String LANGUAGE__LANGUAGE_NAME_KEY =
      'LANGUAGE__LANGUAGE_NAME_KEY';

  static const String APP_INFO__END_DATE_KEY = 'END_DATE';
  static const String APP_INFO__START_DATE_KEY = 'START_DATE';
  static const String APPINFO_PREF_VERSION_NO = 'APPINFO_PREF_VERSION_NO';
  static const String APPINFO_PREF_FORCE_UPDATE = 'APPINFO_PREF_FORCE_UPDATE';
  static const String APPINFO_FORCE_UPDATE_MSG = 'APPINFO_FORCE_UPDATE_MSG';
  static const String APPINFO_FORCE_UPDATE_TITLE = 'APPINFO_FORCE_UPDATE_TITLE';

  static const String FILTERING__DESC = 'desc'; // Don't Change
  static const String FILTERING__ASC = 'asc'; // Don't Change
  static const String FILTERING__ADDED_DATE = 'added_date'; // Don't Change
  static const String FILTERING__TRENDING = 'touch_count'; // Don't Change
  static const String ONE = '1';
  static const String FILTERING_FEATURE = 'featured_date';
  static const String FILTERING_TRENDING = 'touch_count';

  static const String PLATFORM = 'android';

  static const String RATING_ONE = '1';
  static const String RATING_TWO = '2';
  static const String RATING_THREE = '3';
  static const String RATING_FOUR = '4';
  static const String RATING_FIVE = '5';

  static const String IS_DISCOUNT = '1';
  static const String IS_FEATURED = '1';
  static const String ZERO = '0';
  static const String THREE = '3';
  static const String PRICE_LOW = 'Low';
  static const String PRICE_MEDIUM = 'Medium';
  static const String PRICE_HIGH = 'High';
  static const String SHOP_RATING = 'Shop';
  static const String PRODUCT_RATING = 'Product';

  static const String ORDER_TIME_ASAP = 'ORDER_TIME_ASAP';
  static const String ORDER_TIME_SCHEDULE = 'ORDER_TIME_SCHEDULE';

  static const String FILTERING_PRICE = 'unit_price';

  static const String VALUE_HOLDER__USER_ID = 'USERID';
  static const String VALUE_HOLDER__USER_NAME = 'USER_NAME';
  static const String VALUE_HOLDER__NOTI_TOKEN = 'NOTI_TOKEN';
  static const String VALUE_HOLDER__NOTI_MESSAGE = 'NOTI_MESSAGE';
  static const String VALUE_HOLDER__NOTI_SETTING = 'NOTI_SETTING';
  static const String VALUE_HOLDER__USER_ID_TO_VERIFY = 'USERIDTOVERIFY';
  static const String VALUE_HOLDER__USER_NAME_TO_VERIFY = 'USER_NAME_TO_VERIFY';
  static const String VALUE_HOLDER__USER_EMAIL_TO_VERIFY =
      'USER_EMAIL_TO_VERIFY';
  static const String VALUE_HOLDER__USER_PASSWORD_TO_VERIFY =
      'USER_PASSWORD_TO_VERIFY';
  static const String VALUE_HOLDER__START_DATE = 'START_DATE';
  static const String VALUE_HOLDER__END_DATE = 'END_DATE';
  static const String VALUE_HOLDER__PAYPAL_ENABLED = 'PAYPAL_ENABLED';
  static const String VALUE_HOLDER__STRIPE_ENABLED = 'STRIPE_ENABLED';
  static const String VALUE_HOLDER__PAYSTACK_ENABLED = 'PAYSTACK_ENABLED';
  static const String VALUE_HOLDER__COD_ENABLED = 'COD_ENABLED';
  static const String VALUE_HOLDER__BANK_TRANSFER_ENABLE =
      'BANK_TRANSFER_ENABLE';
  static const String VALUE_HOLDER__PUBLISH_KEY = 'PUBLISH_KEY';
  static const String VALUE_HOLDER__PAYSTACK_KEY = 'PAYSTACK_KEY';
  static const String VALUE_HOLDER__STANDART_SHIPPING_ENABLE =
      'STANDART_SHIPPING_ENABLE';
  static const String VALUE_HOLDER__ZONE_SHIPPING_ENABLE =
      'ZONE_SHIPPING_ENABLE';
  static const String VALUE_HOLDER__NO_SHIPPING_ENABLE = 'NO_SHIPPING_ENABLE';

  static const String CALL_BACK_EDIT_TO_PROFILE = 'CALL_BACK_EDIT_TO_PROFILE';

  static const String CATEGORY_ID = 'cat_id';
  static const String SUB_CATEGORY_ID = 'sub_cat_id';
  static const String CATEGORY_NAME = 'cat_name';

  static const String CONST_CATEGORY = 'category';
  static const String CONST_SUB_CATEGORY = 'subcategory';
  static const String CONST_PRODUCT = 'product';
  static const String PIN_MAP = 'PIN_MAP';

  static const String USER_DELECTED = 'deleted';
  static const String USER_BANNED = 'banned';
  static const String USER_UN_PUBLISHED = 'unpublished';

  static const String VALUE_HOLDER__OVERALL_TAX_LABEL = 'OVERALL_TAX_LABEL';
  static const String VALUE_HOLDER__OVERALL_TAX_VALUE = 'OVERALL_TAX_VALUE';
  static const String VALUE_HOLDER__SHIPPING_TAX_LABEL = 'SHIPPING_TAX_LABEL';
  static const String VALUE_HOLDER__SHIPPING_TAX_VALUE = 'SHIPPING_TAX_VALUE';
  static const String VALUE_HOLDER__SHIPPING_ID = 'SHIPPING_ID';
  static const String VALUE_HOLDER__SHOP_ID = 'SHOP_ID';
  static const String VALUE_HOLDER__SHOP_NAME = 'SHOP_NAME';
  static const String VALUE_HOLDER__MESSENGER = 'messenger';
  static const String VALUE_HOLDER__WHATSAPP = 'whapsapp_no';
  static const String VALUE_HOLDER__PHONE = 'about_phone1';
  static const String VALUE_HOLDER__MINIMUM_ORDER_AMOUNT =
      'minimun_order_amount';
  static const String FILTERING_TYPE_NAME_PRODUCT = 'product';
  static const String FILTERING_TYPE_NAME_CATEGORY = 'category';
  static const String FILTERING_TYPE_NAME_SHOP = 'shop';
  static const int REQUEST_CODE__MENU_USER_PROFILE_FRAGMENT = 1001;
  static const int REQUEST_CODE__MENU_FORGOT_PASSWORD_FRAGMENT = 1002;
  static const int REQUEST_CODE__MENU_REGISTER_FRAGMENT = 1003;
  static const int REQUEST_CODE__MENU_VERIFY_EMAIL_FRAGMENT = 1004;
  static const int REQUEST_CODE__MENU_HOME_FRAGMENT = 1005;
  static const int REQUEST_CODE__MENU_LATEST_PRODUCT_FRAGMENT = 1006;
  static const int REQUEST_CODE__MENU_DISCOUNT_PRODUCT_FRAGMENT = 1007;
  static const int REQUEST_CODE__MENU_FEATURED_PRODUCT_FRAGMENT = 1008;
  static const int REQUEST_CODE__MENU_TRENDING_PRODUCT_FRAGMENT = 1009;
  static const int REQUEST_CODE__MENU_COLLECTION_FRAGMENT = 1010;
  static const int REQUEST_CODE__MENU_SELECT_WHICH_USER_FRAGMENT = 1011;
  static const int REQUEST_CODE__MENU_LANGUAGE_FRAGMENT = 1012;
  static const int REQUEST_CODE__MENU_SETTING_FRAGMENT = 1013;
  static const int REQUEST_CODE__MENU_LOGIN_FRAGMENT = 1014;
  static const int REQUEST_CODE__MENU_BLOG_FRAGMENT = 1015;
  static const int REQUEST_CODE__MENU_FAVOURITE_FRAGMENT = 1016;
  static const int REQUEST_CODE__MENU_TRANSACTION_FRAGMENT = 1017;
  static const int REQUEST_CODE__MENU_USER_HISTORY_FRAGMENT = 1018;
  static const int REQUEST_CODE__MENU_TERMS_AND_CONDITION_FRAGMENT = 1019;
  static const int REQUEST_CODE__MENU_CATEGORY_FRAGMENT = 1020;
  static const int REQUEST_CODE__MENU_CONTACT_US_FRAGMENT = 1021;
  static const int REQUEST_CODE__MENU_PHONE_SIGNIN_FRAGMENT = 1022;
  static const int REQUEST_CODE__MENU_PHONE_VERIFY_FRAGMENT = 1023;
  static const int REQUEST_CODE__MENU_FB_SIGNIN_FRAGMENT = 1024;
  static const int REQUEST_CODE__MENU_GOOGLE_VERIFY_FRAGMENT = 1025;

  static const int REQUEST_CODE__DASHBOARD_USER_PROFILE_FRAGMENT = 2001;
  static const int REQUEST_CODE__DASHBOARD_FORGOT_PASSWORD_FRAGMENT = 2002;
  static const int REQUEST_CODE__DASHBOARD_REGISTER_FRAGMENT = 2003;
  static const int REQUEST_CODE__DASHBOARD_VERIFY_EMAIL_FRAGMENT = 2004;
  static const int REQUEST_CODE__DASHBOARD_SHOP_INFO_FRAGMENT = 2005;
  static const int REQUEST_CODE__DASHBOARD_SELECT_WHICH_USER_FRAGMENT = 2006;
  static const int REQUEST_CODE__DASHBOARD_SEARCH_FRAGMENT = 2007;
  static const int REQUEST_CODE__DASHBOARD_BASKET_FRAGMENT = 2008;
  static const int REQUEST_CODE__DASHBOARD_LOGIN_FRAGMENT = 2009;
  static const int REQUEST_CODE__DASHBOARD_PHONE_SIGNIN_FRAGMENT = 2010;
  static const int REQUEST_CODE__DASHBOARD_PHONE_VERIFY_FRAGMENT = 2011;
  static const int REQUEST_CODE__DASHBOARD_FB_SIGNIN_FRAGMENT = 2012;
  static const int REQUEST_CODE__DASHBOARD_GOOGLE_VERIFY_FRAGMENT = 2013;

  static final NumberFormat psFormat = NumberFormat(PsConfig.priceFormat);
  static const String priceTwoDecimalFormatString = '###.00';
  static final NumberFormat priceTwoDecimalFormat =
      NumberFormat(priceTwoDecimalFormatString);

  ///
  /// Hero Tags
  ///
  static const String HERO_TAG__IMAGE = '_image';
  static const String HERO_TAG__TITLE = '_title';
  static const String HERO_TAG__ORIGINAL_PRICE = '_original_price';
  static const String HERO_TAG__UNIT_PRICE = '_unit_price';

  ///
  ///Admob Setting
  ///
  static const bool SHOW_ADMOB = true;
  static const String android__admob_ads_id_key =
      'ca-app-pub-8907881762519005~4489662081';
  static const String android__admob_unit_id_api_key =
      'ca-app-pub-3940256099942544/6300978111';
  static const String ios__admob_ads_id_key =
      'ca-app-pub-8907881762519005~7619625407';
  static const String ios__admob_unit_id_api_key =
      'ca-app-pub-8907881762519005/7488936925';

  ///
  /// Home Page Consts
  ///
  static const String mainMenu = 'mainMenu';
  static const String specialCollection = 'specialCollection';
  static const String featuredItem = 'featuredItem';

  ///
  /// Firebase Auth Providers
  ///
  static const String emailAuthProvider = 'password';
  static const String appleAuthProvider = 'apple';
  static const String facebookAuthProvider = 'facebook';
  static const String googleAuthProvider = 'google';
  static const String defaultEmail = 'admin@ps.com';
  static const String defaultPassword = 'admin@ps.com';

  ///
  /// Error Codes
  ///
  static const String ERROR_CODE_10001 = '10001'; // Totally No Record
  static const String ERROR_CODE_10002 =
      '10002'; // No More Record at pagination

  ////
  /// Colors
  static const Color PENDING_COLOR = Color(0xFFFBC02D);
  static const Color CANCEL_COLOR = Color(0xFF424242);
  static const Color CONFIRM_COLOR = Color(0xFF448AFF);
  static const Color REJECTE_COLOR = Color(0xFF388E3C);
  static const Color COMPLETE_COLOR = Color(0xFFEF5350);
}
