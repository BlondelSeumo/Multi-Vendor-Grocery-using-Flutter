import 'dart:async';
import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/repository/transaction_header_repository.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/basket.dart';
import 'package:fluttermultigrocery/viewobject/basket_selected_add_on.dart';
import 'package:fluttermultigrocery/viewobject/basket_selected_attribute.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_value_holder.dart';
import 'package:fluttermultigrocery/viewobject/transaction_header.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/api/common/ps_resource.dart';
import 'package:fluttermultigrocery/api/common/ps_status.dart';
import 'package:fluttermultigrocery/provider/common/ps_provider.dart';
import 'package:fluttermultigrocery/viewobject/user.dart';

class TransactionHeaderProvider extends PsProvider {
  TransactionHeaderProvider(
      {@required TransactionHeaderRepository repo,
      @required this.psValueHolder,
      int limit = 0})
      : super(repo, limit) {
    _repo = repo;

    print('Transaction Header Provider: $hashCode');

    Utils.checkInternetConnectivity().then((bool onValue) {
      isConnectedToInternet = onValue;
    });

    transactionListStream =
        StreamController<PsResource<List<TransactionHeader>>>.broadcast();
    subscription = transactionListStream.stream
        .listen((PsResource<List<TransactionHeader>> resource) {
      updateOffset(resource.data.length);

      _transactionList = resource;

      if (resource.status != PsStatus.BLOCK_LOADING &&
          resource.status != PsStatus.PROGRESS_LOADING) {
        isLoading = false;
      }

      if (!isDispose) {
        notifyListeners();
      }
    });

    transactionHeaderStream =
        StreamController<PsResource<TransactionHeader>>.broadcast();
    subscriptionObject = transactionHeaderStream.stream
        .listen((PsResource<TransactionHeader> resource) {
      _transactionSubmit = resource;

      if (resource.status != PsStatus.BLOCK_LOADING &&
          resource.status != PsStatus.PROGRESS_LOADING) {
        isLoading = false;
      }

      if (!isDispose) {
        notifyListeners();
      }
    });
  }

  TransactionHeaderRepository _repo;
  PsValueHolder psValueHolder;

  PsResource<TransactionHeader> get transactionHeader => _transactionSubmit;
  PsResource<TransactionHeader> _transactionSubmit =
      PsResource<TransactionHeader>(PsStatus.NOACTION, '', null);
  StreamSubscription<PsResource<TransactionHeader>> subscriptionObject;
  StreamController<PsResource<TransactionHeader>> transactionHeaderStream;

  PsResource<List<TransactionHeader>> _transactionList =
      PsResource<List<TransactionHeader>>(
          PsStatus.NOACTION, '', <TransactionHeader>[]);
  PsResource<List<TransactionHeader>> get transactionList => _transactionList;

  StreamSubscription<PsResource<List<TransactionHeader>>> subscription;
  StreamController<PsResource<List<TransactionHeader>>> transactionListStream;
  @override
  void dispose() {
    subscription.cancel();
    subscriptionObject.cancel();
    isDispose = true;
    print('Transaction Header Provider Dispose: $hashCode');
    super.dispose();
  }

  Future<dynamic> loadTransactionList(String userId) async {
    isLoading = true;

    isConnectedToInternet = await Utils.checkInternetConnectivity();
    await _repo.getAllTransactionList(
        transactionListStream,
        isConnectedToInternet,
        userId,
        limit,
        offset,
        PsStatus.PROGRESS_LOADING);
  }

  Future<dynamic> nextTransactionList() async {
    isConnectedToInternet = await Utils.checkInternetConnectivity();

    if (!isLoading && !isReachMaxData) {
      super.isLoading = true;
      await _repo.getNextPageTransactionList(
          transactionListStream,
          isConnectedToInternet,
          psValueHolder.loginUserId,
          limit,
          offset,
          PsStatus.PROGRESS_LOADING);
    }
  }

  Future<void> resetTransactionList() async {
    isConnectedToInternet = await Utils.checkInternetConnectivity();
    isLoading = true;

    updateOffset(0);

    await _repo.getAllTransactionList(
        transactionListStream,
        isConnectedToInternet,
        psValueHolder.loginUserId,
        limit,
        offset,
        PsStatus.PROGRESS_LOADING);

    isLoading = false;
  }

  Future<dynamic> postTransactionSubmit(
      User user,
      List<Basket> basketList,
      String clientNonce,
      String couponDiscount,
      String taxAmount,
      String totalDiscount,
      String subTotalAmount,
      String shippingAmount,
      String balanceAmount,
      String totalItemAmount,
      String isCod,
      String isPaypal,
      String isStripe,
      String isBank,
      String isRazor,
      String isPaystack,
      String razorId,
      String isPickUp,
      String pickAtShop,
      String deliveryPickupDate,
      String deliveryPickupTime,
      String shippingMethodPrice,
      String shippingMethodName,
      String memoText,
      PsValueHolder valueHolder) async {
    psValueHolder = valueHolder;

    final List<String> attributeIdStr = <String>[];
    List<String> attributeNameStr = <String>[];
    final List<String> attributePriceStr = <String>[];
    final List<String> addOnIdStr = <String>[];
    final List<String> addOnNameStr = <String>[];
    final List<String> addOnPriceStr = <String>[];
    double totalItemCount = 0.0;
    for (Basket basket in basketList) {
      totalItemCount += double.parse(basket.qty);
    }

    final List<Map<String, dynamic>> detailJson = <Map<String, dynamic>>[];
    for (int i = 0; i < basketList.length; i++) {
      attributeIdStr.clear();
      attributeNameStr.clear();
      attributePriceStr.clear();
      addOnIdStr.clear();
      addOnNameStr.clear();
      addOnPriceStr.clear();
      for (BasketSelectedAttribute basketSelectedAttribute
          in basketList[i].basketSelectedAttributeList) {
        attributeIdStr.add(basketSelectedAttribute.headerId);
        attributeNameStr.add(basketSelectedAttribute.name);
        attributePriceStr.add(basketSelectedAttribute.price);
      }

      for (BasketSelectedAddOn basketSelectedAddOn
          in basketList[i].basketSelectedAddOnList) {
        addOnIdStr.add(basketSelectedAddOn.id);
        addOnNameStr.add(basketSelectedAddOn.name);
        addOnPriceStr.add(basketSelectedAddOn.price);
      }

      final DetailMap carJson = DetailMap(
        basketList[i].shopId,
        basketList[i].productId,
        basketList[i].product.name,
        attributeIdStr.join('#').toString(),
        attributeNameStr.join('#').toString(),
        attributePriceStr.join('#').toString(),
        addOnIdStr.join('#').toString(),
        addOnNameStr.join('#').toString(),
        addOnPriceStr.join('#').toString(),
        basketList[i].selectedColorId ?? '',
        basketList[i].selectedColorValue ?? '',
        basketList[i].product.unitPrice,
        basketList[i].basketOriginalPrice,
        basketList[i].product.discountValue,
        basketList[i].product.discountAmount,
        basketList[i].qty,
        basketList[i].product.discountValue,
        basketList[i].product.discountPercent,
        basketList[i].product.currencyShortForm,
        basketList[i].product.currencySymbol,
        basketList[i].product.productUnit,
        basketList[i].product.productMeasurement ?? '',
      );
      attributeNameStr = <String>[];
      detailJson.add(carJson.tojsonData());
    }

    final TransactionSubmitMap newPost = TransactionSubmitMap(
      userId: user.userId,
      shopId: basketList[0].shopId,
      subTotalAmount: Utils.getPriceTwoDecimal(subTotalAmount),
      discountAmount: Utils.getPriceTwoDecimal(totalDiscount),
      couponDiscountAmount: Utils.getPriceTwoDecimal(couponDiscount) ?? '',
      taxAmount: Utils.getPriceTwoDecimal(taxAmount),
      shippingAmount: Utils.getPriceTwoDecimal(shippingAmount) ?? '',
      balanceAmount: Utils.getPriceTwoDecimal(balanceAmount),
      totalItemAmount: Utils.getPriceTwoDecimal(totalItemAmount),
      contactName: user.userName,
      contactPhone: user.userPhone,
      contactEmail: user.userEmail,
      contactAddress: user.address,
      contactAreaId: user.area.id,
      transLat: user.userLat,
      transLng: user.userLng,
      isCod: isCod == PsConst.ONE ? PsConst.ONE : PsConst.ZERO,
      isPickUp: isPickUp == PsConst.ONE ? PsConst.ONE : PsConst.ZERO,
      isPaypal: isPaypal == PsConst.ONE ? PsConst.ONE : PsConst.ZERO,
      isStripe: isStripe == PsConst.ONE ? PsConst.ONE : PsConst.ZERO,
      isBank: isBank == PsConst.ONE ? PsConst.ONE : PsConst.ZERO,
      isRazor: isRazor == PsConst.ONE ? PsConst.ONE : PsConst.ZERO,
      isPaystack: isPaystack == PsConst.ONE ? PsConst.ONE : PsConst.ZERO,
      razorId: razorId,
      pickAtShop: pickAtShop,
      deliveryPickupDate: deliveryPickupDate,
      deliveryPickupTime: deliveryPickupTime,
      paymentMethodNonce: clientNonce,
      transStatusId: PsConst.THREE, // 3 = completed
      currencySymbol: basketList[0].product.currencySymbol,
      currencyShortForm: basketList[0].product.currencyShortForm,
      shippingTaxPercent: psValueHolder.shippingTaxLabel,
      taxPercent: psValueHolder.overAllTaxLabel,
      memo: memoText ?? '',
      totalItemCount: totalItemCount.toString(),
      details: detailJson,
    );
    isLoading = true;

    isConnectedToInternet = await Utils.checkInternetConnectivity();

    _transactionSubmit = await _repo.postTransactionSubmit(
        newPost.toMap(), isConnectedToInternet, PsStatus.PROGRESS_LOADING);

    return _transactionSubmit;
  }
}

class DetailMap {
  DetailMap(
      this.shopId,
      this.productId,
      this.productName,
      this.productCustomizedId,
      this.productCustomizedName,
      this.productCustomizedPrice,
      this.productAddOnId,
      this.productAddOnName,
      this.productAddOnPrice,
      this.productColorId,
      this.productColorCode,
      this.price,
      this.originalPrice,
      this.discountPrice,
      this.discountAmount,
      this.qty,
      this.discountValue,
      this.discountPercent,
      this.currencyShortForm,
      this.currencySymbol,
      this.productUnit,
      this.productMeasurement);
  String shopId,
      productId,
      productName,
      productCustomizedId,
      productCustomizedName,
      productCustomizedPrice,
      productAddOnId,
      productAddOnName,
      productAddOnPrice,
      productColorId,
      productColorCode,
      price,
      originalPrice,
      discountPrice,
      discountAmount,
      qty,
      discountValue,
      discountPercent,
      currencyShortForm,
      currencySymbol,
      productUnit,
      productMeasurement;

  Map<String, dynamic> tojsonData() {
    final Map<String, dynamic> map = <String, dynamic>{};
    map['shop_id'] = shopId;
    map['product_id'] = productId;
    map['product_name'] = productName;
    map['product_customized_id'] = productCustomizedId;
    map['product_customized_name'] = productCustomizedName;
    map['product_customized_price'] = productCustomizedPrice;
    map['product_addon_id'] = productAddOnId;
    map['product_addon_name'] = productAddOnName;
    map['product_addon_price'] = productAddOnPrice;
    map['product_color_id'] = productColorId;
    map['product_color_code'] = productColorCode;
    map['unit_price'] = price;
    map['original_price'] = originalPrice;
    map['discount_price'] = discountPrice;
    map['discount_amount'] = discountAmount;
    map['qty'] = qty;
    map['discount_value'] = discountValue;
    map['discount_percent'] = discountPercent;
    map['currency_short_form'] = currencyShortForm;
    map['currency_symbol'] = currencySymbol;
    map['product_unit'] = productUnit;
    map['product_unit_value'] = productMeasurement;
    return map;
  }
}

class TransactionSubmitMap {
  TransactionSubmitMap(
      {this.userId,
      this.shopId,
      this.subTotalAmount,
      this.discountAmount,
      this.couponDiscountAmount,
      this.taxAmount,
      this.shippingAmount,
      this.balanceAmount,
      this.totalItemAmount,
      this.contactName,
      this.contactPhone,
      this.contactEmail,
      this.contactAddress,
      this.contactAreaId,
      this.transLat,
      this.transLng,
      this.isCod,
      this.pickAtShop,
      this.deliveryPickupDate,
      this.deliveryPickupTime,
      this.isPaypal,
      this.isStripe,
      this.isBank,
      this.isPickUp,
      this.isRazor,
      this.isPaystack,
      this.razorId,
      this.paymentMethodNonce,
      this.transStatusId,
      this.currencySymbol,
      this.currencyShortForm,
      this.shippingTaxPercent,
      this.taxPercent,
      this.memo,
      this.totalItemCount,
      this.details});

  String userId;
  String shopId;
  String subTotalAmount;
  String discountAmount;
  String couponDiscountAmount;
  String taxAmount;
  String shippingAmount;
  String balanceAmount;
  String totalItemAmount;
  String contactName;
  String contactPhone;
  String contactEmail;
  String contactAddress;
  String contactAreaId;
  String transLat;
  String transLng;
  String isPickUp;
  String isCod;
  String pickAtShop;
  String deliveryPickupDate;
  String deliveryPickupTime;
  String isPaypal;
  String isStripe;
  String isBank;
  String isRazor;
  String isPaystack;
  String razorId;
  String paymentMethodNonce;
  String transStatusId;
  String currencySymbol;
  String currencyShortForm;
  String shippingTaxPercent;
  String taxPercent;
  String memo;
  String totalItemCount;
  List<Map<String, dynamic>> details;

  Map<String, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};
    map['user_id'] = userId;
    map['shop_id'] = shopId;
    map['sub_total_amount'] = subTotalAmount;
    map['discount_amount'] = discountAmount;
    map['coupon_discount_amount'] = couponDiscountAmount;
    map['tax_amount'] = taxAmount;
    map['shipping_amount'] = shippingAmount;
    map['balance_amount'] = balanceAmount;
    map['total_item_amount'] = totalItemAmount;
    map['contact_name'] = contactName;
    map['contact_phone'] = contactPhone;
    map['contact_email'] = contactEmail;
    map['contact_address'] = contactAddress;
    map['contact_area_id'] = contactAreaId;
    map['trans_lat'] = transLat;
    map['trans_lng'] = transLng;
    map['is_cod'] = isCod;
    map['pick_at_shop'] = pickAtShop;
    map['delivery_pickup_date'] = deliveryPickupDate;
    map['delivery_pickup_time'] = deliveryPickupTime;
    map['is_paypal'] = isPaypal;
    map['is_stripe'] = isStripe;
    map['is_bank'] = isBank;
    map['is_pickup'] = isPickUp;
    map['is_razor'] = isRazor;
    map['is_paystack'] = isPaystack;
    map['razor_id'] = razorId;
    map['payment_method_nonce'] = paymentMethodNonce;
    map['trans_status_id'] = transStatusId;
    map['currency_symbol'] = currencySymbol;
    map['currency_short_form'] = currencyShortForm;
    map['shipping_tax_percent'] = shippingTaxPercent;
    map['tax_percent'] = taxPercent;
    map['memo'] = memo;
    map['total_item_count'] = totalItemCount;
    map['details'] = details;

    return map;
  }
}
