import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';
import 'package:fluttermultigrocery/viewobject/default_icon.dart';
import 'package:fluttermultigrocery/viewobject/rating_detail.dart';
import 'package:fluttermultigrocery/viewobject/shop_branch.dart';
import 'package:quiver/core.dart';
import 'default_photo.dart';

class Shop extends PsObject<Shop> {
  Shop(
      {this.id,
      this.shippingId,
      this.name,
      this.description,
      this.email,
      this.coordinate,
      this.lat,
      this.lng,
      this.paypalEmail,
      this.paypalEnvironment,
      this.paypalAppidLive,
      this.paypalMerchantname,
      this.paypalCustomerid,
      this.paypalIpnurl,
      this.paypalMemo,
      this.paypalMerchantId,
      this.paypalPublicKey,
      this.paypalPrivateKey,
      this.bankAccount,
      this.bankName,
      this.bankCode,
      this.branchCode,
      this.swiftCode,
      this.codEmail,
      this.stripePublishableKey,
      this.stripeSecretKey,
      this.currencySymbol,
      this.currencyShortForm,
      this.senderEmail,
      this.addedDate,
      this.status,
      this.paymentStatus,
      this.paypalEnabled,
      this.stripeEnabled,
      this.codEnabled,
      this.banktransferEnabled,
      this.isFeatured,
      this.overallTaxLabel,
      this.overallTaxValue,
      this.shippingTaxLabel,
      this.shippingTaxValue,
      this.whapsappNo,
      this.refundPolicy,
      this.privacyPolicy,
      this.terms,
      this.aboutWebsite,
      this.facebook,
      this.googlePlus,
      this.instagram,
      this.youtube,
      this.pinterest,
      this.twitter,
      this.aboutPhone1,
      this.aboutPhone2,
      this.aboutPhone3,
      this.address1,
      this.address2,
      this.address3,
      this.touchCount,
      this.addedUserId,
      this.updatedDate,
      this.updatedUserId,
      this.featuredDate,
      this.messenger,
      this.priceLevel,
      this.highlightedInfo,
      this.standardShippingEnable,
      this.zoneShippingEnable,
      this.noShippingEnable,
      this.addedDateStr,
      this.defaultPhoto,
      this.defaultIcon,
      this.ratingDetail,
      this.openingHour,
      this.closingHour,
      this.closedDate,
      this.overallRating,
      this.pickupEmail,
      this.pickupEnabled,
      this.razorKey,
      this.razorEnabled,
      this.branch});

  String id;
  String shippingId;
  String name;
  String description;
  String email;
  String coordinate;
  String lat;
  String lng;
  String paypalEmail;
  String paypalEnvironment;
  String paypalAppidLive;
  String paypalMerchantname;
  String paypalCustomerid;
  String paypalIpnurl;
  String paypalMemo;
  String paypalMerchantId;
  String paypalPublicKey;
  String paypalPrivateKey;
  String bankAccount;
  String bankName;
  String bankCode;
  String branchCode;
  String swiftCode;
  String codEmail;
  String stripePublishableKey;
  String stripeSecretKey;
  String currencySymbol;
  String currencyShortForm;
  String senderEmail;
  String addedDate;
  String status;
  String paymentStatus;
  String paypalEnabled;
  String stripeEnabled;
  String codEnabled;
  String banktransferEnabled;
  String isFeatured;
  String overallTaxLabel;
  String overallTaxValue;
  String shippingTaxLabel;
  String shippingTaxValue;
  String whapsappNo;
  String refundPolicy;
  String privacyPolicy;
  String terms;
  String aboutWebsite;
  String facebook;
  String googlePlus;
  String instagram;
  String youtube;
  String pinterest;
  String twitter;
  String aboutPhone1;
  String aboutPhone2;
  String aboutPhone3;
  String address1;
  String address2;
  String address3;
  String touchCount;
  String addedUserId;
  String updatedDate;
  String updatedUserId;
  String featuredDate;
  String messenger;
  String priceLevel;
  String highlightedInfo;
  String standardShippingEnable;
  String zoneShippingEnable;
  String noShippingEnable;
  String addedDateStr;
  DefaultPhoto defaultPhoto;
  DefaultIcon defaultIcon;
  RatingDetail ratingDetail;
  String openingHour;
  String closingHour;
  String closedDate;
  String overallRating;
  String pickupEmail;
  String pickupEnabled;
  String razorKey;
  String razorEnabled;
  List<ShopBranch> branch;
  @override
  bool operator ==(dynamic other) => other is Shop && id == other.id;

  @override
  int get hashCode => hash2(id.hashCode, id.hashCode);

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  Shop fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return Shop(
          id: dynamicData['id'],
          shippingId: dynamicData['shipping_id'],
          name: dynamicData['name'],
          description: dynamicData['description'],
          email: dynamicData['email'],
          coordinate: dynamicData['coordinate'],
          lat: dynamicData['lat'],
          lng: dynamicData['lng'],
          paypalEmail: dynamicData['paypal_email'],
          paypalEnvironment: dynamicData['paypal_environment'],
          paypalAppidLive: dynamicData['paypal_appid_live'],
          paypalMerchantname: dynamicData['paypal_merchantname'],
          paypalCustomerid: dynamicData['paypal_customerid'],
          paypalIpnurl: dynamicData['paypal_ipnurl'],
          paypalMemo: dynamicData['paypal_memo'],
          paypalMerchantId: dynamicData['paypal_merchant_id'],
          paypalPublicKey: dynamicData['paypal_public_key'],
          paypalPrivateKey: dynamicData['paypal_private_key'],
          bankAccount: dynamicData['bank_account'],
          bankName: dynamicData['bank_name'],
          bankCode: dynamicData['bank_code'],
          branchCode: dynamicData['branch_code'],
          swiftCode: dynamicData['swift_code'],
          codEmail: dynamicData['cod_email'],
          stripePublishableKey: dynamicData['stripe_publishable_key'],
          stripeSecretKey: dynamicData['stripe_secret_key'],
          currencySymbol: dynamicData['currency_symbol'],
          currencyShortForm: dynamicData['currency_short_form'],
          senderEmail: dynamicData['sender_email'],
          addedDate: dynamicData['added_date'],
          status: dynamicData['status'],
          paymentStatus: dynamicData['payment_status'],
          paypalEnabled: dynamicData['paypal_enabled'],
          stripeEnabled: dynamicData['stripe_enabled'],
          codEnabled: dynamicData['cod_enabled'],
          banktransferEnabled: dynamicData['banktransfer_enabled'],
          isFeatured: dynamicData['is_featured'],
          overallTaxLabel: dynamicData['overall_tax_label'],
          overallTaxValue: dynamicData['overall_tax_value'],
          shippingTaxLabel: dynamicData['shipping_tax_label'],
          shippingTaxValue: dynamicData['shipping_tax_value'],
          whapsappNo: dynamicData['whapsapp_no'],
          refundPolicy: dynamicData['refund_policy'],
          privacyPolicy: dynamicData['privacy_policy'],
          terms: dynamicData['terms'],
          aboutWebsite: dynamicData['about_website'],
          facebook: dynamicData['facebook'],
          googlePlus: dynamicData['google_plus'],
          instagram: dynamicData['instagram'],
          youtube: dynamicData['youtube'],
          pinterest: dynamicData['pinterest'],
          twitter: dynamicData['twitter'],
          aboutPhone1: dynamicData['about_phone1'],
          aboutPhone2: dynamicData['about_phone2'],
          aboutPhone3: dynamicData['about_phone3'],
          address1: dynamicData['address1'],
          address2: dynamicData['address2'],
          address3: dynamicData['address3'],
          touchCount: dynamicData['touch_count'],
          addedUserId: dynamicData['added_user_id'],
          updatedDate: dynamicData['updated_date'],
          updatedUserId: dynamicData['updated_user_id'],
          featuredDate: dynamicData['featured_date'],
          messenger: dynamicData['messenger'],
          priceLevel: dynamicData['price_level'],
          highlightedInfo: dynamicData['highlighted_info'],
          standardShippingEnable: dynamicData['standard_shipping_enable'],
          zoneShippingEnable: dynamicData['zone_shipping_enable'],
          noShippingEnable: dynamicData['no_shipping_enable'],
          addedDateStr: dynamicData['added_date_str'],
          defaultPhoto: DefaultPhoto().fromMap(dynamicData['default_photo']),
          defaultIcon: DefaultIcon().fromMap(dynamicData['default_icon']),
          ratingDetail: RatingDetail().fromMap(dynamicData['rating_details']),
          openingHour: dynamicData['opening_hour'],
          closingHour: dynamicData['closing_hour'],
          closedDate: dynamicData['closed_date'],
          overallRating: dynamicData['overall_rating'],
          pickupEmail: dynamicData['pickup_email'],
          pickupEnabled: dynamicData['pickup_enabled'],
          razorKey: dynamicData['razor_key'],
          razorEnabled: dynamicData['razor_enabled'],
          branch: ShopBranch().fromMapList(dynamicData['restaurant_branch']));
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(dynamic object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['id'] = object.id;
      data['shipping_id'] = object.shippingId;
      data['name'] = object.name;
      data['description'] = object.description;
      data['email'] = object.email;
      data['coordinate'] = object.coordinate;
      data['lat'] = object.lat;
      data['lng'] = object.lng;
      data['paypal_email'] = object.paypalEmail;
      data['paypal_environment'] = object.paypalEnvironment;
      data['paypal_appid_live'] = object.paypalAppidLive;
      data['paypal_merchantname'] = object.paypalMerchantname;
      data['paypal_customerid'] = object.paypalCustomerid;
      data['paypal_ipnurl'] = object.paypalIpnurl;
      data['paypal_memo'] = object.paypalMemo;
      data['paypal_merchant_id'] = object.paypalMerchantId;
      data['paypal_public_key'] = object.paypalPublicKey;
      data['paypal_private_key'] = object.paypalPrivateKey;
      data['bank_account'] = object.bankAccount;
      data['bank_name'] = object.bankName;
      data['bank_code'] = object.bankCode;
      data['branch_code'] = object.branchCode;
      data['swift_code'] = object.swiftCode;
      data['cod_email'] = object.codEmail;
      data['stripe_publishable_key'] = object.stripePublishableKey;
      data['stripe_secret_key'] = object.stripeSecretKey;
      data['currency_symbol'] = object.currencySymbol;
      data['currency_short_form'] = object.currencyShortForm;
      data['sender_email'] = object.senderEmail;
      data['added_date'] = object.addedDate;
      data['status'] = object.status;
      data['payment_status'] = object.paymentStatus;
      data['paypal_enabled'] = object.paypalEnabled;
      data['stripe_enabled'] = object.stripeEnabled;
      data['cod_enabled'] = object.codEnabled;
      data['banktransfer_enabled'] = object.banktransferEnabled;
      data['is_featured'] = object.isFeatured;
      data['overall_tax_label'] = object.overallTaxLabel;
      data['overall_tax_value'] = object.overallTaxValue;
      data['shipping_tax_label'] = object.shippingTaxLabel;
      data['shipping_tax_value'] = object.shippingTaxValue;
      data['whapsapp_no'] = object.whapsappNo;
      data['refund_policy'] = object.refundPolicy;
      data['privacy_policy'] = object.privacyPolicy;
      data['terms'] = object.terms;
      data['about_website'] = object.aboutWebsite;
      data['facebook'] = object.facebook;
      data['google_plus'] = object.googlePlus;
      data['instagram'] = object.instagram;
      data['youtube'] = object.youtube;
      data['pinterest'] = object.pinterest;
      data['twitter'] = object.twitter;
      data['about_phone1'] = object.aboutPhone1;
      data['about_phone2'] = object.aboutPhone2;
      data['about_phone3'] = object.aboutPhone3;
      data['address1'] = object.address1;
      data['address2'] = object.address2;
      data['address3'] = object.address3;
      data['touch_count'] = object.touchCount;
      data['added_user_id'] = object.addedUserId;
      data['updated_date'] = object.updatedDate;
      data['updated_user_id'] = object.updatedUserId;
      data['featured_date'] = object.featuredDate;
      data['messenger'] = object.messenger;
      data['price_level'] = object.priceLevel;
      data['highlighted_info'] = object.highlightedInfo;
      data['standard_shipping_enable'] = object.standardShippingEnable;
      data['zone_shipping_enable'] = object.zoneShippingEnable;
      data['no_shipping_enable'] = object.noShippingEnable;
      data['added_date_str'] = object.addedDateStr;
      data['default_photo'] = DefaultPhoto().toMap(object.defaultPhoto);
      data['default_icon'] = DefaultIcon().toMap(object.defaultIcon);
      data['rating_details'] = RatingDetail().toMap(object.ratingDetail);
      data['opening_hour'] = object.openingHour;
      data['closing_hour'] = object.closingHour;
      data['closed_date'] = object.closedDate;
      data['overall_rating'] = object.overallRating;
      data['pickup_email'] = object.pickupEmail;
      data['pickup_enabled'] = object.pickupEnabled;
      data['razor_key'] = object.razorKey;
      data['razor_enabled'] = object.razorEnabled;
      data['restaurant_branch'] = ShopBranch().toMapList(object.branch);
      return data;
    } else {
      return null;
    }
  }

  @override
  List<Shop> fromMapList(List<dynamic> dynamicDataList) {
    final List<Shop> newFeedList = <Shop>[];
    if (dynamicDataList != null) {
      for (dynamic json in dynamicDataList) {
        if (json != null) {
          newFeedList.add(fromMap(json));
        }
      }
    }
    return newFeedList;
  }

  @override
  List<Map<String, dynamic>> toMapList(List<dynamic> objectList) {
    final List<Map<String, dynamic>> dynamicList = <Map<String, dynamic>>[];

    if (objectList != null) {
      for (dynamic data in objectList) {
        if (data != null) {
          dynamicList.add(toMap(data));
        }
      }
    }
    return dynamicList;
  }
}
