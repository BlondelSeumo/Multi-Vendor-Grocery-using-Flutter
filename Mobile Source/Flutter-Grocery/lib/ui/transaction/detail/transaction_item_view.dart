import 'package:flutter_icons/flutter_icons.dart';
import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/transaction_detail.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

class TransactionItemView extends StatelessWidget {
  const TransactionItemView({
    Key key,
    @required this.transaction,
    this.animationController,
    this.animation,
    this.onTap,
  }) : super(key: key);

  final TransactionDetail transaction;
  final Function onTap;
  final AnimationController animationController;
  final Animation<double> animation;

  @override
  Widget build(BuildContext context) {
    animationController.forward();
    return AnimatedBuilder(
        animation: animationController,
        child: GestureDetector(
          onTap: onTap,
          child: _ItemWidget(
            transaction: transaction,
          ),
        ),
        builder: (BuildContext context, Widget child) {
          return FadeTransition(
              opacity: animation,
              child: Transform(
                transform: Matrix4.translationValues(
                    0.0, 100 * (1.0 - animation.value), 0.0),
                child: child,
              ));
        });
  }
}

class _ItemWidget extends StatelessWidget {
  const _ItemWidget({
    Key key,
    @required this.transaction,
  }) : super(key: key);

  final TransactionDetail transaction;

  @override
  Widget build(BuildContext context) {
    double balancePrice;
    String attributeName;
    const Widget _dividerWidget = Divider(
      height: PsDimens.space2,
    );

    // if (transaction.productAttributeName != null &&
    //     transaction.productAttributeName != '') {
    //   attributeName = transaction.productAttributeName.replaceAll('#', ',');
    // }
    if (transaction.originalPrice != '0' && transaction.discountAmount != '0') {
      balancePrice = (double.parse(transaction.originalPrice) -
              double.parse(transaction.discountAmount)) *
          double.parse(transaction.qty);
    } else {
      balancePrice = double.parse(transaction.originalPrice) *
          double.parse(transaction.qty);
    }
    return Container(
        color: PsColors.backgroundColor,
        margin: const EdgeInsets.only(top: PsDimens.space8),
        padding: const EdgeInsets.only(
          left: PsDimens.space12,
          right: PsDimens.space12,
        ),
        child: Column(
          children: <Widget>[
            Padding(
              padding: const EdgeInsets.all(16.0),
              child: Row(
                children: <Widget>[
                  const Icon(
                    AntDesign.tago,
                  ),
                  const SizedBox(
                    width: PsDimens.space16,
                  ),
                  Expanded(
                    child: Text(
                      transaction.productName ?? '-',
                      textAlign: TextAlign.left,
                      style: Theme.of(context).textTheme.subtitle1,
                    ),
                  ),
                ],
              ),
            ),
            _dividerWidget,
            Row(
              children: <Widget>[
                if (transaction.productColorCode != null &&
                    transaction.productColorCode != '')
                  Container(
                    margin: const EdgeInsets.all(PsDimens.space10),
                    width: PsDimens.space32,
                    height: PsDimens.space32,
                    decoration: BoxDecoration(
                      borderRadius: BorderRadius.circular(20),
                      color: Utils.hexToColor(transaction.productColorCode),
                      // border: Border.all(width: 1, color: PsColors.grey),
                    ),
                  )
                else
                  Container(),
                if (attributeName != null && attributeName != '')
                  Flexible(
                    child: Text(
                      attributeName ?? '',
                      style: Theme.of(context).textTheme.bodyText2,
                    ),
                  ),
                const SizedBox(
                  width: PsDimens.space16,
                ),
              ],
            ),
            _TransactionNoTextWidget(
              transationInfoText:
                  '${transaction.currencySymbol}  ${Utils.getPriceFormat(transaction.originalPrice)}',
              title:
                  '${Utils.getString(context, 'transaction_detail__price')} :',
            ),
            _TransactionNoTextWidget(
              transationInfoText: transaction.discountAmount != null
                  ? ' ${transaction.currencySymbol} ${Utils.getPriceFormat(transaction.discountAmount.toString())}'
                  : '${transaction.currencySymbol} 0.0',
              title:
                  '${Utils.getString(context, 'transaction_detail__discount_avaiable_amount')} :',
            ),
            _TransactionNoTextWidget(
              transationInfoText:
                  '${transaction.currencySymbol} ${Utils.getPriceFormat(transaction.price.toString())}',
              title:
                  '${Utils.getString(context, 'transaction_detail__balance')} :',
            ),
            _TransactionNoTextWidget(
              transationInfoText: '${transaction.qty}',
              title: '${Utils.getString(context, 'transaction_detail__qty')} :',
            ),
            _TransactionNoTextWidget(
              transationInfoText:
                  ' ${transaction.currencySymbol} ${Utils.getPriceFormat(balancePrice.toString())}',
              title:
                  '${Utils.getString(context, 'transaction_detail__sub_total')} :',
            ),
            const SizedBox(height: PsDimens.space12),
            _CustomizedAndAddOnTextWidget(
              infoText:
                  '${transaction.productCustomizedName.replaceAll('#', ', ')}',
              title:
                  '${Utils.getString(context, 'transaction_detail__customized')} :',
            ),
            _CustomizedAndAddOnTextWidget(
              infoText: '${transaction.productAddonName.replaceAll('#', ', ')}',
              title:
                  '${Utils.getString(context, 'transaction_detail__add_on')} :',
            ),
            const SizedBox(
              height: PsDimens.space12,
            ),
          ],
        ));
  }
}

class _CustomizedAndAddOnTextWidget extends StatelessWidget {
  const _CustomizedAndAddOnTextWidget(
      {Key key, @required this.title, @required this.infoText})
      : super(key: key);

  final String title;
  final String infoText;
  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.only(
        left: PsDimens.space16,
        right: PsDimens.space16,
      ),
      child: Column(
        // mainAxisSize: MainAxisSize.max,
        crossAxisAlignment: CrossAxisAlignment.stretch,
        // mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: <Widget>[
          Visibility(
            visible: infoText != '',
            child: Text(
              title,
              style: Theme.of(context).textTheme.bodyText2,
            ),
          ),
          Visibility(
            visible: infoText != '',
            child: Container(
              margin: const EdgeInsets.all(PsDimens.space12),
              child: Text(
                infoText,
                style: Theme.of(context).textTheme.bodyText2,
              ),
            ),
          )
        ],
      ),
    );
  }
}

class _TransactionNoTextWidget extends StatelessWidget {
  const _TransactionNoTextWidget({
    Key key,
    @required this.transationInfoText,
    this.title,
  }) : super(key: key);

  final String transationInfoText;
  final String title;

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.only(
          left: PsDimens.space16,
          right: PsDimens.space16,
          top: PsDimens.space12),
      child: Row(
        mainAxisSize: MainAxisSize.max,
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: <Widget>[
          Text(
            title,
            style: Theme.of(context).textTheme.bodyText2,
          ),
          Text(
            transationInfoText ?? '-',
            style: Theme.of(context).textTheme.bodyText2,
          )
        ],
      ),
    );
  }
}
