import 'package:flutter_icons/flutter_icons.dart';
import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/config/ps_config.dart';
import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/provider/transaction/transaction_detail_provider.dart';
import 'package:fluttermultigrocery/provider/transaction/transaction_status_provider.dart';
import 'package:fluttermultigrocery/repository/tansaction_detail_repository.dart';
import 'package:fluttermultigrocery/repository/transaction_status_repository.dart';
import 'package:fluttermultigrocery/ui/common/ps_ui_widget.dart';
import 'package:fluttermultigrocery/ui/transaction/detail/transaction_item_view.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_value_holder.dart';
import 'package:fluttermultigrocery/viewobject/transaction_header.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:provider/provider.dart';

class TransactionItemListView extends StatefulWidget {
  const TransactionItemListView({
    Key key,
    @required this.transaction,
  }) : super(key: key);

  final TransactionHeader transaction;

  @override
  _TransactionItemListViewState createState() =>
      _TransactionItemListViewState();
}

class _TransactionItemListViewState extends State<TransactionItemListView>
    with TickerProviderStateMixin {
  final ScrollController _scrollController = ScrollController();

  TransactionDetailRepository repo1;
  TransactionDetailProvider _transactionDetailProvider;
  AnimationController animationController;
  Animation<double> animation;
  PsValueHolder valueHolder;

  @override
  void dispose() {
    animationController.dispose();
    animation = null;
    super.dispose();
  }

  @override
  void initState() {
    _scrollController.addListener(() {
      if (_scrollController.position.pixels ==
          _scrollController.position.maxScrollExtent) {
        _transactionDetailProvider
            .nextTransactionDetailList(widget.transaction);
      }
    });

    animationController =
        AnimationController(duration: PsConfig.animation_duration, vsync: this);

    super.initState();
  }

  dynamic data;
  @override
  Widget build(BuildContext context) {
    Future<bool> _requestPop() {
      animationController.reverse().then<dynamic>(
        (void data) {
          if (!mounted) {
            return Future<bool>.value(false);
          }
          Navigator.pop(context, true);
          return Future<bool>.value(true);
        },
      );
      return Future<bool>.value(false);
    }

    final GlobalKey<ScaffoldState> scaffoldKey = GlobalKey<ScaffoldState>();
    repo1 = Provider.of<TransactionDetailRepository>(context);
    valueHolder = Provider.of<PsValueHolder>(context, listen: false);
    return WillPopScope(
        onWillPop: _requestPop,
        child: ChangeNotifierProvider<TransactionDetailProvider>(
          lazy: false,
          create: (BuildContext context) {
            final TransactionDetailProvider provider =
                TransactionDetailProvider(
                    repo: repo1, psValueHolder: valueHolder);
            provider.loadTransactionDetailList(widget.transaction);
            _transactionDetailProvider = provider;
            return provider;
          },
          child: Consumer<TransactionDetailProvider>(builder:
              (BuildContext context, TransactionDetailProvider provider,
                  Widget child) {
            return Scaffold(
              key: scaffoldKey,
              appBar: AppBar(
                brightness: Utils.getBrightnessForAppBar(context),
                iconTheme: Theme.of(context).iconTheme.copyWith(),
                title: Text(
                  Utils.getString(context, 'transaction_detail__title'),
                  textAlign: TextAlign.center,
                  style: Theme.of(context).textTheme.headline6.copyWith(
                        fontWeight: FontWeight.bold,
                      ),
                ),
                elevation: 0,
              ),
              body: Stack(children: <Widget>[
                RefreshIndicator(
                  child: CustomScrollView(
                      controller: _scrollController,
                      scrollDirection: Axis.vertical,
                      slivers: <Widget>[
                        SliverToBoxAdapter(
                          child: _OrderStatusWidget(
                              transaction: widget.transaction,
                              valueHolder: valueHolder,
                              scaffoldKey: scaffoldKey),
                        ),
                        if (widget.transaction.pickAtShop == PsConst.ONE)
                          SliverToBoxAdapter(child: _SelfPickUpWidget())
                        else
                          SliverToBoxAdapter(
                            child: Container(),
                          ),
                        SliverToBoxAdapter(
                          child: _TransactionNoWidget(
                              transaction: widget.transaction,
                              valueHolder: valueHolder,
                              scaffoldKey: scaffoldKey),
                        ),
                        SliverList(
                          delegate: SliverChildBuilderDelegate(
                            (BuildContext context, int index) {
                              if (provider.transactionDetailList.data != null ||
                                  provider
                                      .transactionDetailList.data.isNotEmpty) {
                                final int count =
                                    provider.transactionDetailList.data.length;
                                return TransactionItemView(
                                  animationController: animationController,
                                  animation: Tween<double>(begin: 0.0, end: 1.0)
                                      .animate(
                                    CurvedAnimation(
                                      parent: animationController,
                                      curve: Interval((1 / count) * index, 1.0,
                                          curve: Curves.fastOutSlowIn),
                                    ),
                                  ),
                                  transaction: provider
                                      .transactionDetailList.data[index],
                                );
                              } else {
                                return null;
                              }
                            },
                            childCount:
                                provider.transactionDetailList.data.length,
                          ),
                        ),
                      ]),
                  onRefresh: () {
                    return provider
                        .resetTransactionDetailList(widget.transaction);
                  },
                ),
                PSProgressIndicator(provider.transactionDetailList.status)
              ]),
            );
          }),
        ));
  }
}

class _SelfPickUpWidget extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
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
            padding: const EdgeInsets.only(
                left: PsDimens.space8,
                right: PsDimens.space12,
                top: PsDimens.space12),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: <Widget>[
                Expanded(
                  child: Row(
                    children: <Widget>[
                      const SizedBox(
                        width: PsDimens.space8,
                      ),
                      Icon(
                        MaterialCommunityIcons.note_outline,
                        color: Theme.of(context).iconTheme.color,
                      ),
                      const SizedBox(
                        width: PsDimens.space8,
                      ),
                      Expanded(
                        child: Text(
                            Utils.getString(
                                context, 'transaction_detail__order_type'),
                            textAlign: TextAlign.left,
                            style: Theme.of(context).textTheme.subtitle1),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
          _TransactionNoTextWidget(
            transationInfoText:
                Utils.getString(context, 'transaction_detail__self_pick_up'),
            title: Utils.getString(context, 'transaction_detail__type') + ' :',
          ),
          const SizedBox(height: PsDimens.space12),
        ],
      ),
    );
  }
}

class _OrderStatusWidget extends StatelessWidget {
  const _OrderStatusWidget({
    Key key,
    @required this.transaction,
    @required this.valueHolder,
    this.scaffoldKey,
  }) : super(key: key);

  final TransactionHeader transaction;
  final PsValueHolder valueHolder;
  final GlobalKey<ScaffoldState> scaffoldKey;
  @override
  Widget build(BuildContext context) {
    const Widget _dividerWidget = Divider(
      height: PsDimens.space2,
    );
    final Widget _contentCopyIconWidget = IconButton(
      iconSize: PsDimens.space20,
      icon: Icon(
        Icons.content_copy,
        color: Theme.of(context).iconTheme.color,
      ),
      onPressed: () {
        Clipboard.setData(ClipboardData(text: transaction.transCode));
        scaffoldKey.currentState.showSnackBar(SnackBar(
          content: Tooltip(
            message: Utils.getString(context, 'transaction_detail__copy'),
            child: Text(
              Utils.getString(context, 'transaction_detail__copied_data'),
              style: Theme.of(context)
                  .textTheme
                  .headline6
                  .copyWith(color: PsColors.mainColor),
            ),
            showDuration: const Duration(seconds: 5),
          ),
        ));
      },
    );

    return Container(
        child: Column(
      children: <Widget>[
        Padding(
          padding: const EdgeInsets.all(PsDimens.space8),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: <Widget>[
              Expanded(
                child: Row(
                  children: <Widget>[
                    const SizedBox(
                      width: PsDimens.space8,
                    ),
                    Icon(
                      Icons.offline_pin,
                      color: Theme.of(context).iconTheme.color,
                    ),
                    const SizedBox(
                      width: PsDimens.space8,
                    ),
                    Expanded(
                      child: Text(
                          '${Utils.getString(context, 'transaction_detail__trans_no')} : ${transaction.transCode}',
                          textAlign: TextAlign.left,
                          style: Theme.of(context).textTheme.subtitle1),
                    ),
                  ],
                ),
              ),
              _contentCopyIconWidget,
            ],
          ),
        ),
        _dividerWidget,
        if (transaction.pickAtShop == PsConst.ZERO)
          Column(
            children: <Widget>[
              const SizedBox(
                height: PsDimens.space12,
              ),
              _TransactionStatusListWidget(transaction: transaction)
            ],
          )
        else
          Container()
      ],
    ));
  }
}

class _TransactionStatusListWidget extends StatelessWidget {
  const _TransactionStatusListWidget({
    Key key,
    @required this.transaction,
  }) : super(key: key);

  final TransactionHeader transaction;
  @override
  Widget build(BuildContext context) {
    final TransactionStatusRepository transStatusRepository =
        Provider.of<TransactionStatusRepository>(context);

    return ChangeNotifierProvider<TransactionStatusProvider>(
      lazy: false,
      create: (BuildContext context) {
        final TransactionStatusProvider provider =
            TransactionStatusProvider(repo: transStatusRepository);
        provider.loadTransactionStatusList();
        return provider;
      },
      child: Consumer<TransactionStatusProvider>(
        builder: (BuildContext context, TransactionStatusProvider provider,
            Widget child) {
          return Container(
            margin: const EdgeInsets.only(
                left: PsDimens.space16,
                right: PsDimens.space16,
                top: PsDimens.space8,
                bottom: PsDimens.space8),
            child: CustomScrollView(
                // controller: _scrollController,
                scrollDirection: Axis.vertical,
                shrinkWrap: true,
                slivers: <Widget>[
                  SliverList(
                    delegate: SliverChildBuilderDelegate(
                      (BuildContext context, int index) {
                        if (provider.transactionStatusList.data != null ||
                            provider.transactionStatusList.data.isNotEmpty) {
                          return _ColorCircleWidget(
                            statusTitle: provider
                                .transactionStatusList.data[index].title,
                            statusOrdering: provider
                                .transactionStatusList.data[index].ordering,
                            transaction: transaction,
                            statusLength:
                                provider.transactionStatusList.data.length,
                          );
                        } else {
                          return null;
                        }
                      },
                      childCount: provider.transactionStatusList.data.length,
                    ),
                  ),
                ]),
          );
        },
      ),
    );
  }
}

class _ColorCircleWidget extends StatelessWidget {
  const _ColorCircleWidget({
    Key key,
    @required this.statusTitle,
    @required this.statusOrdering,
    @required this.transaction,
    @required this.statusLength,
  }) : super(key: key);

  final String statusTitle;
  final String statusOrdering;
  final TransactionHeader transaction;
  final int statusLength;
  @override
  Widget build(BuildContext context) {
    final Widget _verticalLineWidget = Container(
      color: PsColors.mainColor,
      width: PsDimens.space4,
      height: PsDimens.space24,
    );
    return Container(
      margin:
          const EdgeInsets.only(left: PsDimens.space8, right: PsDimens.space8),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        mainAxisAlignment: MainAxisAlignment.start,
        mainAxisSize: MainAxisSize.max,
        children: <Widget>[
          const SizedBox(
            width: PsDimens.space8,
          ),
          Container(
            child: Row(
              children: <Widget>[
                Container(
                  alignment: Alignment.center,
                  width: PsDimens.space24,
                  height: PsDimens.space24,
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.circular(12),
                    color: transaction.transStatus.ordering == statusOrdering
                        ? PsColors.mainColor
                        : transaction.transStatus.ordering != '' &&
                                int.parse(transaction.transStatus.ordering) >
                                    int.parse(statusOrdering)
                            ? PsColors.mainColor
                            : Colors.grey[400],
                    // border: Border.all(width: 1, color: Colors.grey),
                  ),
                  child: Text(
                    statusOrdering,
                    style: Theme.of(context).textTheme.caption.copyWith(
                        fontWeight:
                            transaction.transStatus.ordering == statusOrdering
                                ? FontWeight.bold
                                : FontWeight.normal,
                        color: Colors.black),
                  ),
                ),
                const SizedBox(
                  width: PsDimens.space8,
                ),
                Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: Text(
                    statusTitle,
                    style: Theme.of(context).textTheme.bodyText2.copyWith(
                          fontWeight:
                              transaction.transStatus.ordering == statusOrdering
                                  ? FontWeight.bold
                                  : FontWeight.normal,
                        ),
                  ),
                ),
              ],
            ),
          ),
          Container(
            child: Row(
              children: <Widget>[
                const SizedBox(
                  width: PsDimens.space8,
                ),
                Visibility(
                    visible: statusLength.toString() != statusOrdering,
                    child: _verticalLineWidget),
                const SizedBox(
                  width: PsDimens.space16,
                ),
                Visibility(
                  visible: statusTitle == transaction.transStatus.title,
                  child: Container(
                    margin: const EdgeInsets.only(
                        left: PsDimens.space16, bottom: PsDimens.space16),
                    child: Text(
                      transaction.updatedDate == ''
                          ? ''
                          : Utils.getDateFormat(transaction.updatedDate),
                      style: Theme.of(context)
                          .textTheme
                          .caption
                          .copyWith(color: PsColors.black),
                    ),
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}

class _TransactionNoWidget extends StatelessWidget {
  const _TransactionNoWidget({
    Key key,
    @required this.transaction,
    @required this.valueHolder,
    this.scaffoldKey,
  }) : super(key: key);

  final TransactionHeader transaction;
  final PsValueHolder valueHolder;
  final GlobalKey<ScaffoldState> scaffoldKey;

  @override
  Widget build(BuildContext context) {
    const Widget _dividerWidget = Divider(
      height: PsDimens.space2,
    );

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
              padding: const EdgeInsets.only(
                  left: PsDimens.space8,
                  right: PsDimens.space12,
                  top: PsDimens.space12,
                  bottom: PsDimens.space12),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: <Widget>[
                  Expanded(
                    child: Row(
                      children: <Widget>[
                        const SizedBox(
                          width: PsDimens.space8,
                        ),
                        Icon(
                          Octicons.note,
                          color: Theme.of(context).iconTheme.color,
                        ),
                        const SizedBox(
                          width: PsDimens.space8,
                        ),
                        Expanded(
                          child: Text(
                              Utils.getString(
                                  context, 'checkout__order_summary'),
                              textAlign: TextAlign.left,
                              style: Theme.of(context).textTheme.subtitle1),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
            _dividerWidget,
            if (transaction.pickAtShop == PsConst.ONE)
              _TransactionNoTextWidget(
                transationInfoText:
                    '${transaction.deliveryPickupDate} ${transaction.deliveryPickupTime}',
                title:
                    '${Utils.getString(context, 'transaction_detail__order_time')} :',
              )
            else
              Container(),
            _TransactionNoTextWidget(
              transationInfoText: transaction.totalItemCount,
              title:
                  '${Utils.getString(context, 'transaction_detail__total_item_count')} :',
            ),
            _TransactionNoTextWidget(
              transationInfoText:
                  '${transaction.currencySymbol} ${Utils.getPriceFormat(transaction.totalItemAmount)}',
              title:
                  '${Utils.getString(context, 'transaction_detail__total_item_price')} :',
            ),
            _TransactionNoTextWidget(
              transationInfoText: transaction.discountAmount == '0'
                  ? '-'
                  : '${transaction.currencySymbol} ${Utils.getPriceFormat(transaction.discountAmount)}',
              title:
                  '${Utils.getString(context, 'transaction_detail__discount')} :',
            ),
            _TransactionNoTextWidget(
              transationInfoText: transaction.cuponDiscountAmount == '0'
                  ? '-'
                  : '${transaction.currencySymbol} ${Utils.getPriceFormat(transaction.cuponDiscountAmount)}',
              title:
                  '${Utils.getString(context, 'transaction_detail__coupon_discount')} :',
            ),
            const SizedBox(
              height: PsDimens.space12,
            ),
            _dividerWidget,
            _TransactionNoTextWidget(
              transationInfoText:
                  '${transaction.currencySymbol} ${Utils.getPriceFormat(transaction.subTotalAmount)}',
              title:
                  '${Utils.getString(context, 'transaction_detail__sub_total')} :',
            ),
            _TransactionNoTextWidget(
              transationInfoText:
                  '${transaction.currencySymbol} ${Utils.getPriceFormat(transaction.taxAmount)}',
              title:
                  '${Utils.getString(context, 'transaction_detail__tax')}(${transaction.taxPercent} %) :',
            ),
            _TransactionNoTextWidget(
              transationInfoText:
                  '${transaction.currencySymbol} ${Utils.getPriceFormat(transaction.shippingAmount)}',
              title:
                  '${Utils.getString(context, 'transaction_detail__shipping_cost')} :',
            ),
            _TransactionNoTextWidget(
              transationInfoText:
                  '${transaction.currencySymbol} ${Utils.calculateShippingTax(transaction.shippingAmount, transaction.shippingTaxPercent)}',
              title:
                  '${Utils.getString(context, 'transaction_detail__shipping_tax')}(${transaction.shippingTaxPercent} %) :',
            ),
            const SizedBox(
              height: PsDimens.space12,
            ),
            _dividerWidget,
            _TransactionNoTextWidget(
              transationInfoText:
                  '${transaction.currencySymbol} ${Utils.getPriceFormat(transaction.balanceAmount)}',
              title:
                  '${Utils.getString(context, 'transaction_detail__total')} :',
            ),
            const SizedBox(
              height: PsDimens.space12,
            ),
          ],
        ));
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
          left: PsDimens.space12,
          right: PsDimens.space12,
          top: PsDimens.space12),
      child: Row(
        mainAxisSize: MainAxisSize.max,
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: <Widget>[
          Text(
            title,
            style: Theme.of(context)
                .textTheme
                .bodyText2
                .copyWith(fontWeight: FontWeight.normal),
          ),
          Text(
            transationInfoText ?? '-',
            style: Theme.of(context)
                .textTheme
                .bodyText2
                .copyWith(fontWeight: FontWeight.normal),
          )
        ],
      ),
    );
  }
}
