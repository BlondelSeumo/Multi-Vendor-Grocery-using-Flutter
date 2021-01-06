import 'dart:io';

import 'package:braintree_payment/braintree_payment.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_icons/flutter_icons.dart';
import 'package:fluttermultigrocery/api/common/ps_resource.dart';
import 'package:fluttermultigrocery/api/common/ps_status.dart';
import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/config/ps_config.dart';
import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/constant/route_paths.dart';
import 'package:fluttermultigrocery/provider/basket/basket_provider.dart';
import 'package:fluttermultigrocery/provider/coupon_discount/coupon_discount_provider.dart';
import 'package:fluttermultigrocery/provider/shop_info/shop_info_provider.dart';
import 'package:fluttermultigrocery/provider/token/token_provider.dart';
import 'package:fluttermultigrocery/provider/transaction/transaction_header_provider.dart';
import 'package:fluttermultigrocery/provider/user/user_provider.dart';
import 'package:fluttermultigrocery/ui/common/dialog/error_dialog.dart';
import 'package:fluttermultigrocery/ui/common/ps_textfield_widget.dart';
import 'package:fluttermultigrocery/utils/ps_progress_dialog.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/basket.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_value_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/checkout_status_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/transaction_header.dart';
import 'package:provider/provider.dart';
import 'package:razorpay_flutter/razorpay_flutter.dart';

class Checkout3View extends StatefulWidget {
  const Checkout3View(
      this.updateCheckout3ViewState,
      this.basketList,
      this.isClickDeliveryButton,
      this.isClickPickUpButton,
      this.deliveryPickUpDate,
      this.deliveryPickUpTime);

  final Function updateCheckout3ViewState;

  final List<Basket> basketList;
  final bool isClickDeliveryButton;
  final bool isClickPickUpButton;
  final String deliveryPickUpDate;
  final String deliveryPickUpTime;

  @override
  _Checkout3ViewState createState() {
    final _Checkout3ViewState _state = _Checkout3ViewState();
    updateCheckout3ViewState(_state);
    return _state;
  }
}

class _Checkout3ViewState extends State<Checkout3View> {
  bool isCheckBoxSelect = false;
  bool isCashClicked = false;
  bool isPickUpClicked = false;
  bool isPaypalClicked = false;
  bool isStripeClicked = false;
  bool isBankClicked = false;
  bool isRazorClicked = false;
  bool isPayStackClicked = false;

  PsValueHolder valueHolder;
  CouponDiscountProvider couponDiscountProvider;
  BasketProvider basketProvider;
  final TextEditingController memoController = TextEditingController();

  void checkStatus() {
    print('Checking Status ... $isCheckBoxSelect');
  }

  dynamic callBankNow(
      BasketProvider basketProvider,
      UserProvider userLoginProvider,
      TransactionHeaderProvider transactionSubmitProvider) async {
    if (await Utils.checkInternetConnectivity()) {
      if (userLoginProvider.user != null &&
          userLoginProvider.user.data != null) {
        await PsProgressDialog.showDialog(context);
        final PsValueHolder valueHolder =
            Provider.of<PsValueHolder>(context, listen: false);
        final PsResource<TransactionHeader> _apiStatus =
            await transactionSubmitProvider.postTransactionSubmit(
                userLoginProvider.user.data,
                widget.basketList,
                '',
                couponDiscountProvider.couponDiscount.toString(),
                basketProvider.checkoutCalculationHelper.tax.toString(),
                basketProvider.checkoutCalculationHelper.totalDiscount
                    .toString(),
                basketProvider.checkoutCalculationHelper.subTotalPrice
                    .toString(),
                basketProvider.checkoutCalculationHelper.shippingCost
                    .toString(),
                basketProvider.checkoutCalculationHelper.totalPrice.toString(),
                basketProvider.checkoutCalculationHelper.totalOriginalPrice
                    .toString(),
                PsConst.ZERO,
                PsConst.ZERO,
                PsConst.ZERO,
                PsConst.ONE,
                PsConst.ZERO,
                PsConst.ZERO,
                '',
                PsConst.ZERO,
                widget.isClickPickUpButton == true ? PsConst.ONE : PsConst.ZERO,
                widget.deliveryPickUpDate,
                widget.deliveryPickUpTime,
                basketProvider.checkoutCalculationHelper.shippingCost
                    .toString(),
                userLoginProvider.user.data.area.areaName,
                memoController.text,
                valueHolder);

        if (_apiStatus.data != null) {
          PsProgressDialog.dismissDialog();

          await basketProvider.deleteWholeBasketList();
          // Navigator.pop(context, true);
          await Navigator.pushNamed(context, RoutePaths.checkoutSuccess,
              arguments: CheckoutStatusIntentHolder(
                transactionHeader: _apiStatus.data,
              ));
        } else {
          PsProgressDialog.dismissDialog();

          return showDialog<dynamic>(
              context: context,
              builder: (BuildContext context) {
                return ErrorDialog(
                  message: _apiStatus.message,
                );
              });
        }
      }
    } else {
      showDialog<dynamic>(
          context: context,
          builder: (BuildContext context) {
            return ErrorDialog(
              message: Utils.getString(context, 'error_dialog__no_internet'),
            );
          });
    }
  }

  dynamic callCardNow(
      BasketProvider basketProvider,
      UserProvider userLoginProvider,
      TransactionHeaderProvider transactionSubmitProvider) async {
    if (await Utils.checkInternetConnectivity()) {
      if (userLoginProvider.user != null &&
          userLoginProvider.user.data != null) {
        await PsProgressDialog.showDialog(context);
        print(
            basketProvider.checkoutCalculationHelper.subTotalPrice.toString());
        final PsValueHolder valueHolder =
            Provider.of<PsValueHolder>(context, listen: false);

        final PsResource<TransactionHeader> _apiStatus =
            await transactionSubmitProvider.postTransactionSubmit(
                userLoginProvider.user.data,
                widget.basketList,
                '',
                couponDiscountProvider.couponDiscount.toString(),
                basketProvider.checkoutCalculationHelper.tax.toString(),
                basketProvider.checkoutCalculationHelper.totalDiscount
                    .toString(),
                basketProvider.checkoutCalculationHelper.subTotalPrice
                    .toString(),
                basketProvider.checkoutCalculationHelper.shippingCost
                    .toString(),
                basketProvider.checkoutCalculationHelper.totalPrice.toString(),
                basketProvider.checkoutCalculationHelper.totalOriginalPrice
                    .toString(),
                PsConst.ONE,
                PsConst.ZERO,
                PsConst.ZERO,
                PsConst.ZERO,
                PsConst.ZERO,
                PsConst.ZERO,
                '',
                PsConst.ZERO,
                widget.isClickPickUpButton == true ? PsConst.ONE : PsConst.ZERO,
                widget.deliveryPickUpDate,
                widget.deliveryPickUpTime,
                basketProvider.checkoutCalculationHelper.shippingCost
                    .toString(),
                userLoginProvider.user.data.area.areaName,
                memoController.text,
                valueHolder);

        if (_apiStatus.data != null) {
          PsProgressDialog.dismissDialog();
          await basketProvider.deleteWholeBasketList();
          // Navigator.pop(context, true);
          await Navigator.pushNamed(context, RoutePaths.checkoutSuccess,
              arguments: CheckoutStatusIntentHolder(
                transactionHeader: _apiStatus.data,
              ));
        } else {
          PsProgressDialog.dismissDialog();

          return showDialog<dynamic>(
              context: context,
              builder: (BuildContext context) {
                return ErrorDialog(
                  message: _apiStatus.message,
                );
              });
        }
      }
    } else {
      showDialog<dynamic>(
          context: context,
          builder: (BuildContext context) {
            return ErrorDialog(
              message: Utils.getString(context, 'error_dialog__no_internet'),
            );
          });
    }
  }

  dynamic callPickUpNow(
      BasketProvider basketProvider,
      UserProvider userLoginProvider,
      TransactionHeaderProvider transactionSubmitProvider) async {
    if (await Utils.checkInternetConnectivity()) {
      if (userLoginProvider.user != null &&
          userLoginProvider.user.data != null) {
        await PsProgressDialog.showDialog(context);
        print(
            basketProvider.checkoutCalculationHelper.subTotalPrice.toString());
        final PsValueHolder valueHolder =
            Provider.of<PsValueHolder>(context, listen: false);
        final PsResource<TransactionHeader> _apiStatus =
            await transactionSubmitProvider.postTransactionSubmit(
                userLoginProvider.user.data,
                widget.basketList,
                '',
                couponDiscountProvider.couponDiscount.toString(),
                basketProvider.checkoutCalculationHelper.tax.toString(),
                basketProvider.checkoutCalculationHelper.totalDiscount
                    .toString(),
                basketProvider.checkoutCalculationHelper.subTotalPrice
                    .toString(),
                basketProvider.checkoutCalculationHelper.shippingCost
                    .toString(),
                basketProvider.checkoutCalculationHelper.totalPrice.toString(),
                basketProvider.checkoutCalculationHelper.totalOriginalPrice
                    .toString(),
                PsConst.ZERO,
                PsConst.ZERO,
                PsConst.ZERO,
                PsConst.ZERO,
                PsConst.ZERO,
                PsConst.ZERO,
                '',
                PsConst.ONE,
                widget.isClickPickUpButton == true ? PsConst.ONE : PsConst.ZERO,
                widget.deliveryPickUpDate,
                widget.deliveryPickUpTime,
                basketProvider.checkoutCalculationHelper.shippingCost
                    .toString(),
                userLoginProvider.user.data.area.areaName,
                memoController.text,
                valueHolder);

        if (_apiStatus.data != null) {
          PsProgressDialog.dismissDialog();
          await basketProvider.deleteWholeBasketList();
          // Navigator.pop(context, true);
          await Navigator.pushNamed(context, RoutePaths.checkoutSuccess,
              arguments: CheckoutStatusIntentHolder(
                transactionHeader: _apiStatus.data,
              ));
        } else {
          PsProgressDialog.dismissDialog();

          return showDialog<dynamic>(
              context: context,
              builder: (BuildContext context) {
                return ErrorDialog(
                  message: _apiStatus.message,
                );
              });
        }
      }
    } else {
      showDialog<dynamic>(
          context: context,
          builder: (BuildContext context) {
            return ErrorDialog(
              message: Utils.getString(context, 'error_dialog__no_internet'),
            );
          });
    }
  }

  dynamic payRazorNow(
      UserProvider userProvider,
      TransactionHeaderProvider transactionSubmitProvider,
      CouponDiscountProvider couponDiscountProvider,
      PsValueHolder psValueHolder,
      BasketProvider basketProvider) async {
    if (psValueHolder.standardShippingEnable == PsConst.ONE) {
      basketProvider.checkoutCalculationHelper.calculate(
          basketList: widget.basketList,
          couponDiscountString: couponDiscountProvider.couponDiscount,
          psValueHolder: psValueHolder,
          shippingPriceStringFormatting: userProvider.user.data.area.price);
    } else if (psValueHolder.zoneShippingEnable == PsConst.ONE) {
      basketProvider.checkoutCalculationHelper.calculate(
          basketList: widget.basketList,
          couponDiscountString: couponDiscountProvider.couponDiscount,
          psValueHolder: psValueHolder,
          shippingPriceStringFormatting: userProvider.user.data.area.price);
    }
    final ShopInfoProvider _shopInfoProvider =
        Provider.of<ShopInfoProvider>(context, listen: false);
    // Start Razor Payment
    final Razorpay _razorpay = Razorpay();
    _razorpay.on(Razorpay.EVENT_PAYMENT_SUCCESS, _handlePaymentSuccess);
    _razorpay.on(Razorpay.EVENT_PAYMENT_ERROR, _handlePaymentError);
    _razorpay.on(Razorpay.EVENT_EXTERNAL_WALLET, _handleExternalWallet);

    final Map<String, Object> options = <String, Object>{
      'key': _shopInfoProvider.shopInfo.data.razorKey,
      'amount': (double.parse(Utils.getPriceTwoDecimal(basketProvider
                  .checkoutCalculationHelper.totalPrice
                  .toString())) *
              100)
          .round(),
      'name': userProvider.user.data.userName,
      'currency': PsConfig.isRazorSupportMultiCurrency
          ? _shopInfoProvider.shopInfo.data.currencyShortForm
          : PsConfig.defaultRazorCurrency,
      'description': '',
      'prefill': <String, String>{
        'contact': userProvider.user.data.userPhone,
        'email': userProvider.user.data.userEmail
      }
    };

    if (await Utils.checkInternetConnectivity()) {
      _razorpay.open(options);
    } else {
      showDialog<dynamic>(
          context: context,
          builder: (BuildContext context) {
            return ErrorDialog(
              message: Utils.getString(context, 'error_dialog__no_internet'),
            );
          });
    }
  }

  Future<void> _handlePaymentSuccess(PaymentSuccessResponse response) async {
    // Do something when payment succeeds
    print('success');

    print(response);

    await PsProgressDialog.showDialog(context);
    final UserProvider userProvider =
        Provider.of<UserProvider>(context, listen: false);
    final TransactionHeaderProvider transactionSubmitProvider =
        Provider.of<TransactionHeaderProvider>(context, listen: false);
    final BasketProvider basketProvider =
        Provider.of<BasketProvider>(context, listen: false);
    if (userProvider.user != null && userProvider.user.data != null) {
      // final PsResource<TransactionHeader> _apiStatus =
      //     await transactionSubmitProvider.postTransactionSubmit(
      //         userProvider.user.data,
      //         widget.basketList,
      //         '',
      //         couponDiscountProvider.couponDiscount.toString(),
      //         basketProvider.checkoutCalculationHelper.tax.toString(),
      //         basketProvider.checkoutCalculationHelper.totalDiscount.toString(),
      //         basketProvider.checkoutCalculationHelper.subTotalPrice.toString(),
      //         basketProvider.checkoutCalculationHelper.shippingCost.toString(),
      //         basketProvider.checkoutCalculationHelper.totalPrice.toString(),
      //         basketProvider.checkoutCalculationHelper.totalOriginalPrice
      //             .toString(),
      //         PsConst.ZERO,
      //         PsConst.ZERO,
      //         PsConst.ZERO,
      //         PsConst.ZERO,
      //         PsConst.ZERO,
      //         PsConst.ONE,
      //         response.paymentId,
      //         // basketProvider.checkoutCalculationHelper.shippingCost.toString(),
      //         // userProvider.user.data.area.areaName,
      //         memoController.text);
      final PsValueHolder valueHolder =
          Provider.of<PsValueHolder>(context, listen: false);
      final PsResource<TransactionHeader> _apiStatus =
          await transactionSubmitProvider.postTransactionSubmit(
              userProvider.user.data,
              widget.basketList,
              '',
              couponDiscountProvider.couponDiscount.toString(),
              basketProvider.checkoutCalculationHelper.tax.toString(),
              basketProvider.checkoutCalculationHelper.totalDiscount.toString(),
              basketProvider.checkoutCalculationHelper.subTotalPrice.toString(),
              basketProvider.checkoutCalculationHelper.shippingCost.toString(),
              basketProvider.checkoutCalculationHelper.totalPrice.toString(),
              basketProvider.checkoutCalculationHelper.totalOriginalPrice
                  .toString(),
              PsConst.ZERO,
              PsConst.ZERO,
              PsConst.ZERO,
              PsConst.ZERO,
              PsConst.ZERO,
              PsConst.ONE,
              response.paymentId.toString(),
              PsConst.ONE,
              widget.isClickPickUpButton == true ? PsConst.ONE : PsConst.ZERO,
              widget.deliveryPickUpDate,
              widget.deliveryPickUpTime,
              basketProvider.checkoutCalculationHelper.shippingCost.toString(),
              userProvider.user.data.area.areaName,
              memoController.text,
              valueHolder);

      if (_apiStatus.data != null) {
        PsProgressDialog.dismissDialog();

        if (_apiStatus.status == PsStatus.SUCCESS) {
          await basketProvider.deleteWholeBasketList();

          // Navigator.pop(context, true);
          await Navigator.pushNamed(context, RoutePaths.checkoutSuccess,
              arguments: CheckoutStatusIntentHolder(
                transactionHeader: _apiStatus.data,
              ));
        } else {
          PsProgressDialog.dismissDialog();

          return showDialog<dynamic>(
              context: context,
              builder: (BuildContext context) {
                return ErrorDialog(
                  message: _apiStatus.message,
                );
              });
        }
      } else {
        PsProgressDialog.dismissDialog();

        return showDialog<dynamic>(
            context: context,
            builder: (BuildContext context) {
              return ErrorDialog(
                message: _apiStatus.message,
              );
            });
      }
    }
  }

  void _handlePaymentError(PaymentFailureResponse response) {
    // Do something when payment fails
    print('error');
    showDialog<dynamic>(
        context: context,
        builder: (BuildContext context) {
          return ErrorDialog(
            message: Utils.getString(context, 'checkout3__payment_fail'),
          );
        });
  }

  void _handleExternalWallet(ExternalWalletResponse response) {
    // Do something when an external wallet is selected
    print('external wallet');
    showDialog<dynamic>(
        context: context,
        builder: (BuildContext context) {
          return ErrorDialog(
            message:
                Utils.getString(context, 'checkout3__payment_not_supported'),
          );
        });
  }

  dynamic payNow(
      String clientNonce,
      UserProvider userProvider,
      TransactionHeaderProvider transactionSubmitProvider,
      CouponDiscountProvider couponDiscountProvider,
      PsValueHolder psValueHolder,
      BasketProvider basketProvider) async {
    if (psValueHolder.standardShippingEnable == PsConst.ONE) {
      basketProvider.checkoutCalculationHelper.calculate(
          basketList: widget.basketList,
          couponDiscountString: couponDiscountProvider.couponDiscount,
          psValueHolder: psValueHolder,
          shippingPriceStringFormatting: userProvider.user.data.area.price);
    } else if (psValueHolder.zoneShippingEnable == PsConst.ONE) {
      basketProvider.checkoutCalculationHelper.calculate(
          basketList: widget.basketList,
          couponDiscountString: couponDiscountProvider.couponDiscount,
          psValueHolder: psValueHolder,
          shippingPriceStringFormatting: userProvider.user.data.area.price);
    }

    final BraintreePayment braintreePayment = BraintreePayment();
    final dynamic data = await braintreePayment.showDropIn(
        nonce: clientNonce,
        amount:
            basketProvider.checkoutCalculationHelper.totalPriceFormattedString,
        enableGooglePay: true);
    print('${Utils.getString(context, 'checkout__payment_response')} $data');

    if (await Utils.checkInternetConnectivity()) {
      if (data != null && data != 'error' && data != 'cancelled') {
        print(data);

        await PsProgressDialog.showDialog(context);

        if (userProvider.user != null && userProvider.user.data != null) {
          final PsValueHolder valueHolder =
              Provider.of<PsValueHolder>(context, listen: false);
          final PsResource<TransactionHeader> _apiStatus =
              await transactionSubmitProvider.postTransactionSubmit(
                  userProvider.user.data,
                  widget.basketList,
                  Platform.isIOS ? data : data['paymentNonce'],
                  couponDiscountProvider.couponDiscount.toString(),
                  basketProvider.checkoutCalculationHelper.tax.toString(),
                  basketProvider.checkoutCalculationHelper.totalDiscount
                      .toString(),
                  basketProvider.checkoutCalculationHelper.subTotalPrice
                      .toString(),
                  basketProvider.checkoutCalculationHelper.shippingCost
                      .toString(),
                  basketProvider.checkoutCalculationHelper.totalPrice
                      .toString(),
                  basketProvider.checkoutCalculationHelper.totalOriginalPrice
                      .toString(),
                  PsConst.ZERO,
                  PsConst.ONE,
                  PsConst.ZERO,
                  PsConst.ZERO,
                  PsConst.ZERO,
                  PsConst.ZERO,
                  '',
                  PsConst.ZERO,
                  widget.isClickPickUpButton == true
                      ? PsConst.ONE
                      : PsConst.ZERO,
                  widget.deliveryPickUpDate,
                  widget.deliveryPickUpTime,
                  basketProvider.checkoutCalculationHelper.shippingCost
                      .toString(),
                  userProvider.user.data.area.areaName,
                  memoController.text,
                  valueHolder);

          if (_apiStatus.data != null) {
            PsProgressDialog.dismissDialog();

            if (_apiStatus.status == PsStatus.SUCCESS) {
              await basketProvider.deleteWholeBasketList();

              // Navigator.pop(context, true);
              await Navigator.pushNamed(context, RoutePaths.checkoutSuccess,
                  arguments: CheckoutStatusIntentHolder(
                    transactionHeader: _apiStatus.data,
                  ));
            } else {
              PsProgressDialog.dismissDialog();

              return showDialog<dynamic>(
                  context: context,
                  builder: (BuildContext context) {
                    return ErrorDialog(
                      message: _apiStatus.message,
                    );
                  });
            }
          } else {
            PsProgressDialog.dismissDialog();

            return showDialog<dynamic>(
                context: context,
                builder: (BuildContext context) {
                  return ErrorDialog(
                    message: _apiStatus.message,
                  );
                });
          }
        }
      }
    } else {
      showDialog<dynamic>(
          context: context,
          builder: (BuildContext context) {
            return ErrorDialog(
              message: Utils.getString(context, 'error_dialog__no_internet'),
            );
          });
    }
  }

  @override
  Widget build(BuildContext context) {
    valueHolder = Provider.of<PsValueHolder>(context);
    return Consumer<TransactionHeaderProvider>(builder: (BuildContext context,
        TransactionHeaderProvider transactionHeaderProvider, Widget child) {
      return Consumer<BasketProvider>(builder:
          (BuildContext context, BasketProvider basketProvider, Widget child) {
        return Consumer<UserProvider>(builder:
            (BuildContext context, UserProvider userProvider, Widget child) {
          return Consumer<TokenProvider>(builder: (BuildContext context,
              TokenProvider tokenProvider, Widget child) {
            // if (tokenProvider.tokenData != null &&
            //     tokenProvider.tokenData.data != null &&
            //     tokenProvider.tokenData.data.message != null) {
            couponDiscountProvider = Provider.of<CouponDiscountProvider>(
                context,
                listen: false); // Listen : False is important.
            basketProvider = Provider.of<BasketProvider>(context,
                listen: false); // Listen : False is important.

            return SingleChildScrollView(
              child: Container(
                color: PsColors.backgroundColor,
                padding: const EdgeInsets.only(
                  left: PsDimens.space12,
                  right: PsDimens.space12,
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: <Widget>[
                    const SizedBox(
                      height: PsDimens.space16,
                    ),
                    Container(
                      margin: const EdgeInsets.only(
                          left: PsDimens.space16, right: PsDimens.space16),
                      child: Text(
                        Utils.getString(context, 'checkout3__payment_method'),
                        style: Theme.of(context).textTheme.subtitle1,
                      ),
                    ),
                    const SizedBox(
                      height: PsDimens.space16,
                    ),
                    const Divider(
                      height: 2,
                    ),
                    const SizedBox(
                      height: PsDimens.space8,
                    ),
                    Consumer<ShopInfoProvider>(builder: (BuildContext context,
                        ShopInfoProvider shopInfoProvider, Widget child) {
                      if (shopInfoProvider.shopInfo.data == null) {
                        return Container();
                      }
                      return SingleChildScrollView(
                        scrollDirection: Axis.horizontal,
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: <Widget>[
                            Row(
                              children: <Widget>[
                                Visibility(
                                  visible: shopInfoProvider
                                              .shopInfo.data.codEnabled ==
                                          '1' &&
                                      widget.isClickDeliveryButton,
                                  child: Container(
                                    width: PsDimens.space140,
                                    height: PsDimens.space140,
                                    padding:
                                        const EdgeInsets.all(PsDimens.space8),
                                    child: InkWell(
                                      onTap: () {
                                        if (!isCashClicked) {
                                          isCashClicked = true;
                                          isPickUpClicked = false;
                                          isPaypalClicked = false;
                                          isStripeClicked = false;
                                          isBankClicked = false;
                                          isRazorClicked = false;
                                          isPayStackClicked = false;
                                        }

                                        setState(() {});
                                      },
                                      child: checkIsCashSelected(
                                          Utils.getString(
                                              context, 'checkout3__cod')),
                                    ),
                                  ),
                                ),
                                Visibility(
                                  visible: shopInfoProvider
                                              .shopInfo.data.pickupEnabled ==
                                          '1' &&
                                      widget.isClickPickUpButton,
                                  child: Container(
                                    width: PsDimens.space140,
                                    height: PsDimens.space140,
                                    padding:
                                        const EdgeInsets.all(PsDimens.space8),
                                    child: InkWell(
                                      onTap: () {
                                        if (!isPickUpClicked) {
                                          isCashClicked = false;
                                          isPickUpClicked = true;
                                          isPaypalClicked = false;
                                          isStripeClicked = false;
                                          isBankClicked = false;
                                          isRazorClicked = false;
                                          isPayStackClicked = false;
                                        }

                                        setState(() {});
                                      },
                                      child: checkIsPickUpSelected(
                                          Utils.getString(
                                              context, 'checkout3__pick_up')),
                                    ),
                                  ),
                                ),
                                Visibility(
                                  visible: shopInfoProvider
                                          .shopInfo.data.paypalEnabled ==
                                      '1',
                                  child: Container(
                                    width: PsDimens.space140,
                                    height: PsDimens.space140,
                                    padding:
                                        const EdgeInsets.all(PsDimens.space8),
                                    child: InkWell(
                                      onTap: () {
                                        if (!isPaypalClicked) {
                                          isCashClicked = false;
                                          isPickUpClicked = false;
                                          isPaypalClicked = true;
                                          isStripeClicked = false;
                                          isBankClicked = false;
                                          isRazorClicked = false;
                                          isPayStackClicked = false;
                                        }

                                        setState(() {});
                                      },
                                      child: checkIsPaypalSelected(),
                                    ),
                                  ),
                                ),
                                Visibility(
                                  visible: shopInfoProvider
                                          .shopInfo.data.stripeEnabled ==
                                      '1',
                                  child: Container(
                                    width: PsDimens.space140,
                                    height: PsDimens.space140,
                                    padding:
                                        const EdgeInsets.all(PsDimens.space8),
                                    child: InkWell(
                                      onTap: () async {
                                        if (!isStripeClicked) {
                                          isCashClicked = false;
                                          isPickUpClicked = false;
                                          isPaypalClicked = false;
                                          isStripeClicked = true;
                                          isBankClicked = false;
                                          isRazorClicked = false;
                                          isPayStackClicked = false;
                                        }

                                        setState(() {});
                                      },
                                      child: checkIsStripeSelected(),
                                    ),
                                  ),
                                ),
                                Visibility(
                                  visible: shopInfoProvider
                                          .shopInfo.data.banktransferEnabled ==
                                      '1',
                                  child: Container(
                                    width: PsDimens.space140,
                                    height: PsDimens.space140,
                                    padding:
                                        const EdgeInsets.all(PsDimens.space8),
                                    child: InkWell(
                                      onTap: () {
                                        if (!isBankClicked) {
                                          isCashClicked = false;
                                          isPickUpClicked = false;
                                          isPaypalClicked = false;
                                          isStripeClicked = false;
                                          isBankClicked = true;
                                          isRazorClicked = false;
                                          isPayStackClicked = false;
                                        }

                                        setState(() {});
                                      },
                                      child: checkIsBankSelected(),
                                    ),
                                  ),
                                ),
                                Visibility(
                                  visible: shopInfoProvider
                                          .shopInfo.data.razorEnabled ==
                                      '1',
                                  child: Container(
                                    width: PsDimens.space140,
                                    height: PsDimens.space140,
                                    padding:
                                        const EdgeInsets.all(PsDimens.space8),
                                    child: InkWell(
                                      onTap: () {
                                        if (!isRazorClicked) {
                                          isCashClicked = false;
                                          isPickUpClicked = false;
                                          isPaypalClicked = false;
                                          isStripeClicked = false;
                                          isBankClicked = false;
                                          isRazorClicked = true;
                                          isPayStackClicked = false;
                                        }

                                        setState(() {});
                                      },
                                      child: checkIsRazorSelected(),
                                    ),
                                  ),
                                ),
                                Visibility(
                                  visible: shopInfoProvider
                                          .shopInfo.data.paystackEnabled ==
                                      PsConst.ONE,
                                  child: Container(
                                    width: PsDimens.space140,
                                    height: PsDimens.space140,
                                    padding:
                                        const EdgeInsets.all(PsDimens.space8),
                                    child: InkWell(
                                      onTap: () {
                                        if (!isPayStackClicked) {
                                          isCashClicked = false;
                                          isPaypalClicked = false;
                                          isStripeClicked = false;
                                          isBankClicked = false;
                                          isRazorClicked = false;
                                          isPayStackClicked = true;
                                        }

                                        setState(() {});
                                      },
                                      child: checkIsPayStackSelected(),
                                    ),
                                  ),
                                ),
                              ],
                            ),
                            const SizedBox(
                              height: PsDimens.space12,
                            ),
                            Container(
                              margin: const EdgeInsets.only(
                                  left: PsDimens.space16,
                                  right: PsDimens.space16),
                              child: showOrHideCashText(
                                  shopInfoProvider.shopInfo.data.pickupMessage),
                            ),
                            const SizedBox(
                              height: PsDimens.space8,
                            ),
                          ],
                        ),
                      );
                    }),
                    PsTextFieldWidget(
                        titleText: Utils.getString(context, 'checkout3__memo'),
                        height: PsDimens.space80,
                        textAboutMe: true,
                        hintText: Utils.getString(context, 'checkout3__memo'),
                        keyboardType: TextInputType.multiline,
                        textEditingController: memoController),
                    Row(
                      children: <Widget>[
                        Checkbox(
                          activeColor: PsColors.mainColor,
                          value: isCheckBoxSelect,
                          onChanged: (bool value) {
                            setState(() {
                              updateCheckBox();
                            });
                          },
                        ),
                        Expanded(
                          child: InkWell(
                            child: Text(
                              Utils.getString(
                                  context, 'checkout3__agree_policy'),
                              style: Theme.of(context).textTheme.bodyText2,
                              maxLines: 2,
                            ),
                            onTap: () {
                              setState(() {
                                updateCheckBox();
                              });
                            },
                          ),
                        ),
                      ],
                    ),
                    const SizedBox(
                      height: PsDimens.space60,
                    ),
                  ],
                ),
              ),
            );
            // } else {
            //   return Container();
            // }
          });
        });
      });
    });
  }

  void updateCheckBox() {
    if (isCheckBoxSelect) {
      isCheckBoxSelect = false;
    } else {
      isCheckBoxSelect = true;
    }
  }

  Widget checkIsCashSelected(String title) {
    if (!isCashClicked) {
      return changeCashCardToWhite(title);
    } else {
      return changeCashCardToOrange(title);
    }
  }

  Widget checkIsPickUpSelected(String title) {
    if (!isPickUpClicked) {
      return changeCashCardToWhite(title);
    } else {
      return changeCashCardToOrange(title);
    }
  }

  Widget changeCashCardToWhite(String title) {
    return Container(
        width: PsDimens.space140,
        child: Container(
          decoration: BoxDecoration(
            color: PsColors.coreBackgroundColor,
            borderRadius:
                const BorderRadius.all(Radius.circular(PsDimens.space8)),
          ),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            crossAxisAlignment: CrossAxisAlignment.center,
            mainAxisSize: MainAxisSize.min,
            children: <Widget>[
              const SizedBox(
                height: PsDimens.space4,
              ),
              Container(
                  width: 50, height: 50, child: const Icon(Ionicons.md_cash)),
              Container(
                margin: const EdgeInsets.only(
                  left: PsDimens.space16,
                  right: PsDimens.space16,
                ),
                child: Text(title,
                    textAlign: TextAlign.center,
                    style: Theme.of(context)
                        .textTheme
                        .subtitle1
                        .copyWith(height: 1.3)),
              ),
            ],
          ),
        ));
  }

  Widget changeCashCardToOrange(String title) {
    return Container(
      width: PsDimens.space140,
      child: Container(
        decoration: BoxDecoration(
          color: PsColors.mainColor,
          borderRadius:
              const BorderRadius.all(Radius.circular(PsDimens.space8)),
        ),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          mainAxisSize: MainAxisSize.min,
          children: <Widget>[
            const SizedBox(
              height: PsDimens.space4,
            ),
            Container(
                width: 50,
                height: 50,
                child: Icon(
                  Ionicons.md_cash,
                  color: PsColors.white,
                )),
            Container(
              margin: const EdgeInsets.only(
                left: PsDimens.space16,
                right: PsDimens.space16,
              ),
              child: Text(title,
                  textAlign: TextAlign.center,
                  style: Theme.of(context)
                      .textTheme
                      .subtitle1
                      .copyWith(color: PsColors.white)),
            ),
          ],
        ),
      ),
    );
  }

  Widget checkIsPaypalSelected() {
    if (!isPaypalClicked) {
      return changePaypalCardToWhite();
    } else {
      return changePaypalCardToOrange();
    }
  }

  Widget changePaypalCardToOrange() {
    return Container(
      width: PsDimens.space140,
      child: Container(
        decoration: BoxDecoration(
          color: PsColors.mainColor,
          borderRadius:
              const BorderRadius.all(Radius.circular(PsDimens.space8)),
        ),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          mainAxisSize: MainAxisSize.min,
          children: <Widget>[
            const SizedBox(
              height: PsDimens.space4,
            ),
            Container(
                width: 50,
                height: 50,
                child: Icon(Foundation.paypal, color: PsColors.white)),
            Container(
              margin: const EdgeInsets.only(
                left: PsDimens.space16,
                right: PsDimens.space16,
              ),
              child: Text(Utils.getString(context, 'checkout3__paypal'),
                  style: Theme.of(context)
                      .textTheme
                      .subtitle1
                      .copyWith(height: 1.3, color: PsColors.white)),
            ),
          ],
        ),
      ),
    );
  }

  Widget changePaypalCardToWhite() {
    return Container(
        width: PsDimens.space140,
        child: Container(
          decoration: BoxDecoration(
            color: PsColors.coreBackgroundColor,
            borderRadius:
                const BorderRadius.all(Radius.circular(PsDimens.space8)),
          ),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            crossAxisAlignment: CrossAxisAlignment.center,
            mainAxisSize: MainAxisSize.min,
            children: <Widget>[
              const SizedBox(
                height: PsDimens.space4,
              ),
              Container(
                  width: 50, height: 50, child: const Icon(Foundation.paypal)),
              Container(
                margin: const EdgeInsets.only(
                  left: PsDimens.space16,
                  right: PsDimens.space16,
                ),
                child: Text(Utils.getString(context, 'checkout3__paypal'),
                    style: Theme.of(context)
                        .textTheme
                        .subtitle1
                        .copyWith(height: 1.3)),
              ),
            ],
          ),
        ));
  }

  Widget checkIsStripeSelected() {
    if (!isStripeClicked) {
      return changeStripeCardToWhite();
    } else {
      return changeStripeCardToOrange();
    }
  }

  Widget changeStripeCardToWhite() {
    return Container(
      width: PsDimens.space140,
      child: Container(
        decoration: BoxDecoration(
          color: PsColors.coreBackgroundColor,
          borderRadius:
              const BorderRadius.all(Radius.circular(PsDimens.space8)),
        ),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          mainAxisSize: MainAxisSize.min,
          children: <Widget>[
            const SizedBox(
              height: PsDimens.space4,
            ),
            Container(width: 50, height: 50, child: const Icon(Icons.payment)),
            Container(
              margin: const EdgeInsets.only(
                left: PsDimens.space16,
                right: PsDimens.space16,
              ),
              child: Text(Utils.getString(context, 'checkout3__stripe'),
                  style: Theme.of(context)
                      .textTheme
                      .subtitle1
                      .copyWith(height: 1.3)),
            ),
          ],
        ),
      ),
    );
  }

  Widget changeStripeCardToOrange() {
    return Container(
      width: PsDimens.space140,
      child: Container(
        decoration: BoxDecoration(
          color: PsColors.mainColor,
          borderRadius:
              const BorderRadius.all(Radius.circular(PsDimens.space8)),
        ),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          mainAxisSize: MainAxisSize.min,
          children: <Widget>[
            const SizedBox(
              height: PsDimens.space4,
            ),
            Container(
                width: 50,
                height: 50,
                child: Icon(Icons.payment, color: PsColors.white)),
            Container(
              margin: const EdgeInsets.only(
                left: PsDimens.space16,
                right: PsDimens.space16,
              ),
              child: Text(Utils.getString(context, 'checkout3__stripe'),
                  style: Theme.of(context)
                      .textTheme
                      .subtitle1
                      .copyWith(height: 1.3, color: PsColors.white)),
            ),
          ],
        ),
      ),
    );
  }

  Widget checkIsPayStackSelected() {
    if (!isPayStackClicked) {
      return changePayStackCardToWhite();
    } else {
      return changePayStackCardToOrange();
    }
  }

  Widget changePayStackCardToOrange() {
    return Container(
      width: PsDimens.space140,
      child: Container(
        decoration: BoxDecoration(
          color: PsColors.mainColor,
          borderRadius:
              const BorderRadius.all(Radius.circular(PsDimens.space8)),
        ),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          mainAxisSize: MainAxisSize.min,
          children: <Widget>[
            const SizedBox(
              height: PsDimens.space4,
            ),
            Container(
                width: 50,
                height: 50,
                child: Icon(Ionicons.md_cash, color: PsColors.white)),
            Container(
              margin: const EdgeInsets.only(
                  left: PsDimens.space16, right: PsDimens.space16),
              child: Text(Utils.getString(context, 'checkout3__paystack'),
                  style: Theme.of(context)
                      .textTheme
                      .subtitle1
                      .copyWith(height: 1.3, color: PsColors.white)),
            ),
          ],
        ),
      ),
    );
  }

  Widget changePayStackCardToWhite() {
    return Container(
      width: PsDimens.space140,
      child: Container(
        decoration: BoxDecoration(
          color: PsColors.coreBackgroundColor,
          borderRadius:
              const BorderRadius.all(Radius.circular(PsDimens.space8)),
        ),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          mainAxisSize: MainAxisSize.min,
          children: <Widget>[
            const SizedBox(
              height: PsDimens.space4,
            ),
            Container(
                width: 50, height: 50, child: const Icon(Ionicons.md_cash)),
            Container(
              margin: const EdgeInsets.only(
                  left: PsDimens.space16, right: PsDimens.space16),
              child: Text(Utils.getString(context, 'checkout3__paystack'),
                  style: Theme.of(context)
                      .textTheme
                      .subtitle1
                      .copyWith(height: 1.3)),
            ),
          ],
        ),
      ),
    );
  }

  Widget checkIsBankSelected() {
    if (!isBankClicked) {
      return changeBankCardToWhite();
    } else {
      return changeBankCardToOrange();
    }
  }

  Widget changeBankCardToOrange() {
    return Container(
      width: PsDimens.space140,
      child: Container(
        decoration: BoxDecoration(
          color: PsColors.mainColor,
          borderRadius:
              const BorderRadius.all(Radius.circular(PsDimens.space8)),
        ),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          mainAxisSize: MainAxisSize.min,
          children: <Widget>[
            const SizedBox(
              height: PsDimens.space4,
            ),
            Container(
                width: 50,
                height: 50,
                child: Icon(Icons.payment, color: PsColors.white)),
            Container(
              margin: const EdgeInsets.only(
                  left: PsDimens.space16, right: PsDimens.space16),
              child: Text(Utils.getString(context, 'checkout3__bank'),
                  style: Theme.of(context)
                      .textTheme
                      .subtitle1
                      .copyWith(height: 1.3, color: PsColors.white)),
            ),
          ],
        ),
      ),
    );
  }

  Widget changeBankCardToWhite() {
    return Container(
      width: PsDimens.space140,
      child: Container(
        decoration: BoxDecoration(
          color: PsColors.coreBackgroundColor,
          borderRadius:
              const BorderRadius.all(Radius.circular(PsDimens.space8)),
        ),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          mainAxisSize: MainAxisSize.min,
          children: <Widget>[
            const SizedBox(
              height: PsDimens.space4,
            ),
            Container(width: 50, height: 50, child: const Icon(Icons.payment)),
            Container(
              margin: const EdgeInsets.only(
                  left: PsDimens.space16, right: PsDimens.space16),
              child: Text(Utils.getString(context, 'checkout3__bank'),
                  style: Theme.of(context)
                      .textTheme
                      .subtitle1
                      .copyWith(height: 1.3)),
            ),
          ],
        ),
      ),
    );
  }

  Widget checkIsRazorSelected() {
    if (!isRazorClicked) {
      return changeRazorCardToWhite();
    } else {
      return changeRazorCardToOrange();
    }
  }

  Widget changeRazorCardToOrange() {
    return Container(
      width: PsDimens.space140,
      child: Container(
        decoration: BoxDecoration(
          color: PsColors.mainColor,
          borderRadius:
              const BorderRadius.all(Radius.circular(PsDimens.space8)),
        ),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          mainAxisSize: MainAxisSize.min,
          children: <Widget>[
            const SizedBox(
              height: PsDimens.space4,
            ),
            Container(
                width: 50,
                height: 50,
                child: Icon(Icons.payment, color: PsColors.white)),
            Container(
              margin: const EdgeInsets.only(
                  left: PsDimens.space16, right: PsDimens.space16),
              child: Text(Utils.getString(context, 'checkout3__razor'),
                  style: Theme.of(context)
                      .textTheme
                      .subtitle1
                      .copyWith(height: 1.3, color: PsColors.white)),
            ),
          ],
        ),
      ),
    );
  }

  Widget changeRazorCardToWhite() {
    return Container(
      width: PsDimens.space140,
      child: Container(
        decoration: BoxDecoration(
          color: PsColors.coreBackgroundColor,
          borderRadius:
              const BorderRadius.all(Radius.circular(PsDimens.space8)),
        ),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          mainAxisSize: MainAxisSize.min,
          children: <Widget>[
            const SizedBox(
              height: PsDimens.space4,
            ),
            Container(width: 50, height: 50, child: const Icon(Icons.payment)),
            Container(
              margin: const EdgeInsets.only(
                  left: PsDimens.space16, right: PsDimens.space16),
              child: Text(Utils.getString(context, 'checkout3__razor'),
                  style: Theme.of(context)
                      .textTheme
                      .subtitle1
                      .copyWith(height: 1.3)),
            ),
          ],
        ),
      ),
    );
  }

  Widget showOrHideCashText(String pickUpMessage) {
    if (isCashClicked) {
      return Text(Utils.getString(context, 'checkout3__cod_message'),
          style: Theme.of(context).textTheme.bodyText2);
    } else if (isPickUpClicked) {
      return Text(pickUpMessage, style: Theme.of(context).textTheme.bodyText2);
    } else {
      return null;
    }
  }
}
