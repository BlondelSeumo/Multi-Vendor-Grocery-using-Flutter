import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/constant/route_paths.dart';
import 'package:fluttermultigrocery/ui/app_info/app_info_view.dart';
import 'package:fluttermultigrocery/ui/app_loading/app_loading-view.dart';
import 'package:fluttermultigrocery/ui/category/filter_list/category_filter_list_view.dart';
import 'package:fluttermultigrocery/ui/category/list/category_list_view_container.dart';
import 'package:fluttermultigrocery/ui/checkout/pay_stack_view.dart';
import 'package:fluttermultigrocery/ui/dashboard/core/dashboard_view.dart';
import 'package:fluttermultigrocery/ui/dashboard/core/single_dashboard_view.dart';
import 'package:fluttermultigrocery/ui/dashboard/home/shop_dashboard_container_view.dart';
import 'package:fluttermultigrocery/ui/gallery/grid/shop_gallery_grid_view.dart';
import 'package:fluttermultigrocery/ui/language/list/language_list_view.dart';
import 'package:fluttermultigrocery/ui/map/map_pin_view.dart';
import 'package:fluttermultigrocery/ui/noti/detail/noti_view.dart';
import 'package:fluttermultigrocery/ui/noti/list/noti_list_view.dart';
import 'package:fluttermultigrocery/ui/product/detail/product_detail_view.dart';
import 'package:fluttermultigrocery/ui/product/list_with_filter/filter/category/filter_list_view.dart';
import 'package:fluttermultigrocery/ui/product/list_with_filter/filter/filter/item_search_view.dart';
import 'package:fluttermultigrocery/ui/product/list_with_filter/filter/sort/item_sorting_view.dart';
import 'package:fluttermultigrocery/ui/rating/list/shop_rating_list_view.dart';
import 'package:fluttermultigrocery/ui/search/home_item_search_container_view.dart';
import 'package:fluttermultigrocery/ui/shop/branch/shop_branch_container.dart';
import 'package:fluttermultigrocery/ui/shop/shop_info_container_view.dart';
import 'package:fluttermultigrocery/ui/shop_list/shop_list_view.dart';
import 'package:fluttermultigrocery/ui/subcategory/filter/sub_category_search_list_view.dart';
import 'package:fluttermultigrocery/ui/subcategory/list/sub_category_grid_view.dart';
import 'package:fluttermultigrocery/ui/user/edit_profile/area_list_view.dart';
import 'package:fluttermultigrocery/ui/user/edit_profile/edit_profile_view.dart';
import 'package:fluttermultigrocery/ui/user/forgot_password/forgot_password_container_view.dart';
import 'package:fluttermultigrocery/ui/user/login/login_container_view.dart';
import 'package:fluttermultigrocery/ui/user/more/more_container_view.dart';
import 'package:fluttermultigrocery/ui/user/password_update/change_password_view.dart';
import 'package:fluttermultigrocery/ui/user/verify/verify_email_container_view.dart';
import 'package:fluttermultigrocery/viewobject/category.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/blog_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/paystack_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/privacy_policy_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/product_detail_intent_holder.dart';
import 'package:fluttermultigrocery/ui/checkout/checkout_container_view.dart';
import 'package:fluttermultigrocery/ui/basket/list/basket_list_container.dart';
import 'package:fluttermultigrocery/ui/blog/detail/blog_view.dart';
import 'package:fluttermultigrocery/ui/blog/list/blog_list_container.dart';
import 'package:fluttermultigrocery/ui/checkout/checkout_status_view.dart';
import 'package:fluttermultigrocery/ui/checkout/credit_card_view.dart';
import 'package:fluttermultigrocery/ui/collection/header_list/collection_header_list_container.dart';
import 'package:fluttermultigrocery/ui/comment/detail/comment_detail_list_view.dart';
import 'package:fluttermultigrocery/ui/comment/list/comment_list_view.dart';
import 'package:fluttermultigrocery/ui/force_update/force_update_view.dart';
import 'package:fluttermultigrocery/ui/gallery/detail/gallery_view.dart';
import 'package:fluttermultigrocery/ui/gallery/grid/gallery_grid_view.dart';
import 'package:fluttermultigrocery/ui/history/list/history_list_container.dart';
import 'package:fluttermultigrocery/ui/noti/notification_setting/notification_setting_view.dart';
import 'package:fluttermultigrocery/ui/product/attribute_detail/attribute_detail_list_view.dart';
import 'package:fluttermultigrocery/ui/product/collection_product/product_list_by_collection_id_view.dart';
import 'package:fluttermultigrocery/ui/product/favourite/favourite_product_list_container.dart';
import 'package:fluttermultigrocery/ui/product/list_with_filter/product_list_with_filter_container.dart';
import 'package:fluttermultigrocery/ui/rating/list/rating_list_view.dart';
import 'package:fluttermultigrocery/ui/setting/setting_container_view.dart';
import 'package:fluttermultigrocery/ui/setting/setting_privacy_policy_view.dart';
import 'package:fluttermultigrocery/ui/transaction/detail/transaction_item_list_view.dart';
import 'package:fluttermultigrocery/ui/transaction/list/transaction_list_container.dart';
import 'package:fluttermultigrocery/ui/user/phone/sign_in/phone_sign_in_container_view.dart';
import 'package:fluttermultigrocery/ui/user/phone/verify_phone/verify_phone_container_view.dart';
import 'package:fluttermultigrocery/ui/user/profile/profile_container_view.dart';
import 'package:fluttermultigrocery/ui/user/register/register_container_view.dart';
import 'package:fluttermultigrocery/viewobject/blog.dart';
import 'package:fluttermultigrocery/viewobject/comment_header.dart';
import 'package:fluttermultigrocery/viewobject/default_photo.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/attribute_detail_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/checkout_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/checkout_status_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/credit_card_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/product_list_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/shop_data_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/shop_info_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/shop_list_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/verify_phone_internt_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/map_pin_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/product_parameter_holder.dart';
import 'package:fluttermultigrocery/viewobject/noti.dart';
import 'package:fluttermultigrocery/viewobject/product.dart';
import 'package:fluttermultigrocery/viewobject/ps_app_version.dart';

import 'package:fluttermultigrocery/viewobject/shop_info.dart';
import 'package:fluttermultigrocery/viewobject/transaction_header.dart';

Route<dynamic> generateRoute(RouteSettings settings) {
  switch (settings.name) {
    case '/':
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              AppLoadingView());

    case '${RoutePaths.home}':
      return MaterialPageRoute<dynamic>(
          settings: const RouteSettings(name: RoutePaths.home),
          builder: (BuildContext context) {
            return DashboardView();
          });

    case '${RoutePaths.singlehome}':
      final Object args = settings.arguments;
      final ShopDataIntentHolder shopDataIntentHolder = args ?? String;
      return MaterialPageRoute<dynamic>(
          settings: const RouteSettings(name: RoutePaths.home),
          builder: (BuildContext context) {
            return SingleDashboardView(
                shopId: shopDataIntentHolder.shopId,
                shopName: shopDataIntentHolder.shopName);
          });

    case '${RoutePaths.shop_dashboard}':
      final Object args = settings.arguments;
      final ShopDataIntentHolder shopDataIntentHolder = args ?? String;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              ShopDashboardContainerView(
                  shopId: shopDataIntentHolder.shopId,
                  shopName: shopDataIntentHolder.shopName));

    case '${RoutePaths.force_update}':
      final Object args = settings.arguments;
      final PSAppVersion psAppVersion = args ?? PSAppVersion;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              ForceUpdateView(psAppVersion: psAppVersion));

    case '${RoutePaths.user_register_container}':
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              RegisterContainerView());
    case '${RoutePaths.login_container}':
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              LoginContainerView());

    case '${RoutePaths.shop_info_container}':
      final Object args = settings.arguments;
      final String shopId = args ?? String;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              ShopInfoContainerView(shopId: shopId));

    case '${RoutePaths.shopbranchContainer}':
      final Object args = settings.arguments;
      // final String shopId = args ?? String;
      // final ShopInfo shopInfo = args ?? ShopInfo;
      final ShopInfoDataIntentHolder shopInfoDataIntentHolder = args ?? String;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              ShopBranchContainerView(
                shopInfo: shopInfoDataIntentHolder.shopInfo,
                shopId: shopInfoDataIntentHolder.shopId,
              ));

    case '${RoutePaths.appinfo}':
      return MaterialPageRoute<dynamic>(
          builder: (BuildContext context) => AppInfoView());

    case '${RoutePaths.more}':
      return MaterialPageRoute<dynamic>(builder: (BuildContext context) {
        final Object args = settings.arguments;
        final String userName = args ?? String;
        return MoreContainerView(userName: userName);
      });

    case '${RoutePaths.mapPin}':
      return MaterialPageRoute<dynamic>(builder: (BuildContext context) {
        final Object args = settings.arguments;
        final MapPinIntentHolder mapPinIntentHolder =
            args ?? MapPinIntentHolder;
        return MapPinView(
          flag: mapPinIntentHolder.flag,
          maplat: mapPinIntentHolder.mapLat,
          maplng: mapPinIntentHolder.mapLng,
        );
      });

    case '${RoutePaths.user_verify_email_container}':
      final Object args = settings.arguments;
      final String userId = args ?? String;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              VerifyEmailContainerView(userId: userId));

    case '${RoutePaths.user_forgot_password_container}':
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              ForgotPasswordContainerView());

    case '${RoutePaths.user_phone_signin_container}':
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              PhoneSignInContainerView());

    case '${RoutePaths.user_phone_verify_container}':
      final Object args = settings.arguments;

      final VerifyPhoneIntentHolder verifyPhoneIntentParameterHolder =
          args ?? VerifyPhoneIntentHolder;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              VerifyPhoneContainerView(
                userName: verifyPhoneIntentParameterHolder.userName,
                phoneNumber: verifyPhoneIntentParameterHolder.phoneNumber,
                phoneId: verifyPhoneIntentParameterHolder.phoneId,
              ));

    case '${RoutePaths.user_update_password}':
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              ChangePasswordView());

    case '${RoutePaths.profile_container}':
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              ProfileContainerView());

    case '${RoutePaths.languageList}':
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              LanguageListView());

    case '${RoutePaths.categoryList}':
      final Object args = settings.arguments;
      final String title = args ?? String;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              CategoryListViewContainerView(appBarTitle: title));

    case '${RoutePaths.notiList}':
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              const NotiListView());
    case '${RoutePaths.creditCard}':
      final Object args = settings.arguments;

      final CreditCardIntentHolder creditCardParameterHolder =
          args ?? CreditCardIntentHolder;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              CreditCardView(
                basketList: creditCardParameterHolder.basketList,
                couponDiscount: creditCardParameterHolder.couponDiscount,
                transactionSubmitProvider:
                    creditCardParameterHolder.transactionSubmitProvider,
                userLoginProvider: creditCardParameterHolder.userProvider,
                basketProvider: creditCardParameterHolder.basketProvider,
                psValueHolder: creditCardParameterHolder.psValueHolder,
                memoText: creditCardParameterHolder.memoText,
                publishKey: creditCardParameterHolder.publishKey,
                isClickPickUpButton:
                    creditCardParameterHolder.isClickPickUpButton,
                deliveryPickUpDate:
                    creditCardParameterHolder.deliveryPickUpDate,
                deliveryPickUpTime:
                    creditCardParameterHolder.deliveryPickUpTime,
              ));

    case '${RoutePaths.paystack}':
      final Object args = settings.arguments;

      final PayStackInterntHolder payStackInterntHolder =
          args ?? PayStackInterntHolder;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              PayStackView(
                basketList: payStackInterntHolder.basketList,
                couponDiscount: payStackInterntHolder.couponDiscount,
                transactionSubmitProvider:
                    payStackInterntHolder.transactionSubmitProvider,
                userLoginProvider: payStackInterntHolder.userLoginProvider,
                basketProvider: payStackInterntHolder.basketProvider,
                psValueHolder: payStackInterntHolder.psValueHolder,
                memoText: payStackInterntHolder.memoText,
                paystackKey: payStackInterntHolder.paystackKey,
                isClickPickUpButton: payStackInterntHolder.isClickPickUpButton,
                deliveryPickUpDate: payStackInterntHolder.deliveryPickUpDate,
                deliveryPickUpTime: payStackInterntHolder.deliveryPickUpTime,
              ));

    case '${RoutePaths.notiSetting}':
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              NotificationSettingView());
    case '${RoutePaths.setting}':
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              SettingContainerView());
    //case '${RoutePaths.subCategoryList}':
    //final Object args = settings.arguments;
    //final Category category = args ?? Category;
    //return PageRouteBuilder<dynamic>(
    //pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
    // SubCategoryListView(category: category));

    case '${RoutePaths.subCategoryGrid}':
      return MaterialPageRoute<Category>(builder: (BuildContext context) {
        final Object args = settings.arguments;
        final Category category = args ?? Category;
        return SubCategoryGridView(category: category);
      });

    case '${RoutePaths.noti}':
      final Object args = settings.arguments;
      final Noti noti = args ?? Noti;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              NotiView(noti: noti));

    case '${RoutePaths.filterProductList}':
      final Object args = settings.arguments;
      final ProductListIntentHolder productListIntentHolder =
          args ?? ProductListIntentHolder;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              ProductListWithFilterContainerView(
                  appBarTitle: productListIntentHolder.appBarTitle,
                  productParameterHolder:
                      productListIntentHolder.productParameterHolder));

    case '${RoutePaths.dashboardsearchFood}':
      final Object args = settings.arguments;
      final ProductListIntentHolder productListIntentHolder =
          args ?? ProductListIntentHolder;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              HomeItemSearchContainerView(
                  // appBarTitle: productListIntentHolder.appBarTitle,
                  productParameterHolder:
                      productListIntentHolder.productParameterHolder));
    case '${RoutePaths.shopList}':
      final Object args = settings.arguments;
      final ShopListIntentHolder shopListIntentHolder =
          args ?? ShopListIntentHolder;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              ShopListView(
                  appBarTitle: shopListIntentHolder.appBarTitle,
                  shopParameterHolder:
                      shopListIntentHolder.shopParameterHolder));

    case '${RoutePaths.checkoutSuccess}':
      final Object args = settings.arguments;

      final CheckoutStatusIntentHolder checkoutStatusIntentHolder =
          args ?? CheckoutStatusIntentHolder;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              CheckoutStatusView(
                transactionHeader: checkoutStatusIntentHolder.transactionHeader,
              ));

    case '${RoutePaths.privacyPolicy}':
      final Object args = settings.arguments;
      final PrivacyPolicyIntentHolder privacyPolicyIntentHolder = args ?? int;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              SettingPrivacyPolicyView(
                  title: privacyPolicyIntentHolder.title,
                  description: privacyPolicyIntentHolder.description));

    case '${RoutePaths.blogList}':
      final Object args = settings.arguments;
      final BlogIntentHolder blogIntentHolder = args ?? CreditCardIntentHolder;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              BlogListContainerView(
                noBlogListForShop: blogIntentHolder.noBlogListForShop,
                shopId: blogIntentHolder.shopId,
              ));

    case '${RoutePaths.blogDetail}':
      final Object args = settings.arguments;
      final Blog blog = args ?? Blog;
      return MaterialPageRoute<Widget>(builder: (BuildContext context) {
        return BlogView(
          blog: blog,
          heroTagImage: blog.id,
        );
      });

    case '${RoutePaths.transactionList}':
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              TransactionListContainerView());

    case '${RoutePaths.historyList}':
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              HistoryListContainerView());

    case '${RoutePaths.transactionDetail}':
      final Object args = settings.arguments;
      final TransactionHeader transaction = args ?? TransactionHeader;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              TransactionItemListView(
                transaction: transaction,
              ));

    case '${RoutePaths.productDetail}':
      final Object args = settings.arguments;
      final ProductDetailIntentHolder holder =
          args ?? ProductDetailIntentHolder;
      return MaterialPageRoute<Widget>(builder: (BuildContext context) {
        return ProductDetailView(
          product: holder.product,
          heroTagImage: holder.heroTagImage,
          heroTagTitle: holder.heroTagTitle,
          heroTagOriginalPrice: holder.heroTagOriginalPrice,
          heroTagUnitPrice: holder.heroTagUnitPrice,
          intentId: holder.id,
          intentQty: holder.qty,
          intentSelectedColorId: holder.selectedColorId,
          intentSelectedColorValue: holder.selectedColorValue,
          intentBasketPrice: holder.basketPrice,
          intentBasketSelectedAttributeList: holder.basketSelectedAttributeList,
          intentBasketSelectedAddOnList: holder.basketSelectedAddOnList,
        );
      });

    case '${RoutePaths.filterExpantion}':
      final dynamic args = settings.arguments;

      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              FilterListView(selectedData: args));

    case '${RoutePaths.commentList}':
      final Object args = settings.arguments;
      final Product product = args ?? Product;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              CommentListView(product: product));

    case '${RoutePaths.itemSearch}':
      final Object args = settings.arguments;
      final ProductParameterHolder productParameterHolder =
          args ?? ProductParameterHolder;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              ItemSearchView(productParameterHolder: productParameterHolder));

    case '${RoutePaths.itemSort}':
      final Object args = settings.arguments;
      final ProductParameterHolder productParameterHolder =
          args ?? ProductParameterHolder;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              ItemSortingView(productParameterHolder: productParameterHolder));

    case '${RoutePaths.commentDetail}':
      final Object args = settings.arguments;
      final CommentHeader commentHeader = args ?? CommentHeader;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              CommentDetailListView(
                commentHeader: commentHeader,
              ));

    case '${RoutePaths.favouriteProductList}':
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              FavouriteProductListContainerView());

    case '${RoutePaths.collectionProductList}':
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              CollectionHeaderListContainerView());

    case '${RoutePaths.productListByCollectionId}':
      final Object args = settings.arguments;
      final ProductListByCollectionIdView productCollectionIdView =
          args ?? ProductListByCollectionIdView;

      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              ProductListByCollectionIdView(
                productCollectionHeader:
                    productCollectionIdView.productCollectionHeader,
                appBarTitle: productCollectionIdView.appBarTitle,
              ));

    case '${RoutePaths.ratingList}':
      final Object args = settings.arguments;
      final String productDetailId = args ?? String;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              RatingListView(productDetailid: productDetailId));

    case '${RoutePaths.shopRatingList}':
      final Object args = settings.arguments;
      final String shopInfoId = args ?? String;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              ShopRatingListView(shopInfoId: shopInfoId));

    case '${RoutePaths.editProfile}':
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              EditProfileView());

    case '${RoutePaths.areaList}':
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              AreaListView());

    case '${RoutePaths.galleryGrid}':
      final Object args = settings.arguments;
      final Product product = args ?? Product;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              GalleryGridView(product: product));

    case '${RoutePaths.shopGalleryGrid}':
      final Object args = settings.arguments;
      final ShopInfo shopInfo = args ?? ShopInfo;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              ShopGalleryGridView(shopInfo: shopInfo));

    case '${RoutePaths.galleryDetail}':
      final Object args = settings.arguments;
      final DefaultPhoto selectedDefaultImage = args ?? DefaultPhoto;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              GalleryView(selectedDefaultImage: selectedDefaultImage));

    case '${RoutePaths.searchCategory}':
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              CategoryFilterListView());
    case '${RoutePaths.searchSubCategory}':
      final Object args = settings.arguments;
      final String category = args ?? String;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              SubCategorySearchListView(categoryId: category));

    case '${RoutePaths.basketList}':
      return MaterialPageRoute<Widget>(builder: (BuildContext context) {
        return const BasketListContainerView();
      });

    case '${RoutePaths.checkout_container}':
      final Object args = settings.arguments;

      final CheckoutIntentHolder checkoutIntentHolder =
          args ?? CheckoutIntentHolder;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              CheckoutContainerView(
                basketList: checkoutIntentHolder.basketList,
              ));

    case '${RoutePaths.attributeDetailList}':
      final Object args = settings.arguments;
      final AttributeDetailIntentHolder attributeDetailIntentHolder =
          args ?? AttributeDetailIntentHolder;
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              AttributeDetailListView(
                customizedDetailList:
                    attributeDetailIntentHolder.attributeDetail,
                product: attributeDetailIntentHolder.product,
              ));

    default:
      return PageRouteBuilder<dynamic>(
          pageBuilder: (_, Animation<double> a1, Animation<double> a2) =>
              AppInfoView());
  }
}
