import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/config/ps_config.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/provider/rating/shop_rating_provider.dart';
import 'package:fluttermultigrocery/provider/shop_info/shop_info_provider.dart';
import 'package:fluttermultigrocery/repository/product_repository.dart';
import 'package:fluttermultigrocery/repository/shop_info_repository.dart';
import 'package:fluttermultigrocery/repository/shop_rating_repository.dart';
import 'package:fluttermultigrocery/ui/common/base/ps_widget_with_appbar_with_two_provider.dart';
import 'package:fluttermultigrocery/ui/common/dialog/error_dialog.dart';
import 'package:fluttermultigrocery/ui/common/ps_admob_banner_widget.dart';
import 'package:fluttermultigrocery/ui/common/ps_button_widget.dart';
import 'package:fluttermultigrocery/ui/common/smooth_star_rating_widget.dart';
import 'package:fluttermultigrocery/ui/rating/entry/shop_rating_input_dialog.dart';
import 'package:fluttermultigrocery/ui/rating/item/shop_rating_list_item.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_value_holder.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

class ShopRatingListView extends StatefulWidget {
  const ShopRatingListView({
    Key key,
    @required this.shopInfoId,
  }) : super(key: key);

  final String shopInfoId;
  @override
  _ShopRatingListViewState createState() => _ShopRatingListViewState();
}

class _ShopRatingListViewState extends State<ShopRatingListView>
    with SingleTickerProviderStateMixin {
  AnimationController animationController;
  ShopRatingRepository shopRatingRepo;
  ShopRatingProvider shopRatingProvider;
  ShopInfoProvider shopInfoProvider;
  ShopInfoRepository shopInfoRepository;
  PsValueHolder psValueHolder;

  @override
  void initState() {
    animationController =
        AnimationController(duration: PsConfig.animation_duration, vsync: this);
    super.initState();
  }

  @override
  void dispose() {
    animationController.dispose();
    super.dispose();
  }

  bool isConnectedToInternet = false;
  bool isSuccessfullyLoaded = true;

  void checkConnection() {
    Utils.checkInternetConnectivity().then((bool onValue) {
      isConnectedToInternet = onValue;
      if (isConnectedToInternet && PsConfig.showAdMob) {
        setState(() {});
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    if (!isConnectedToInternet && PsConfig.showAdMob) {
      print('loading ads....');
      checkConnection();
    }
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

    shopRatingRepo = Provider.of<ShopRatingRepository>(context);
    shopInfoRepository = Provider.of<ShopInfoRepository>(context);
    psValueHolder = Provider.of<PsValueHolder>(context);
    return WillPopScope(
        onWillPop: _requestPop,
        child: PsWidgetWithAppBarWithTwoProvider<ShopRatingProvider,
                ShopInfoProvider>(
            appBarTitle: Utils.getString(context, 'rating_list__title') ?? '',
            actions: <Widget>[
              IconButton(
                icon: const Icon(
                  Icons.border_color,
                ),
                onPressed: () async {
                  if (await Utils.checkInternetConnectivity()) {
                    Utils.navigateOnUserVerificationView(context, () async {
                      await showDialog<dynamic>(
                          context: context,
                          builder: (BuildContext context) {
                            return ShopRatingInputDialog(
                                shopInfoProvider: shopInfoProvider);
                          });

                      shopRatingProvider
                          .refreshShopRatingList(widget.shopInfoId);

                      await shopInfoProvider.loadShopInfo(
                        widget.shopInfoId,
                      );
                    });
                  } else {
                    showDialog<dynamic>(
                        context: context,
                        builder: (BuildContext context) {
                          return ErrorDialog(
                            message: Utils.getString(
                                context, 'error_dialog__no_internet'),
                          );
                        });
                  }
                },
              ),
            ],
            initProvider1: () {
              shopRatingProvider = ShopRatingProvider(repo: shopRatingRepo);
              return shopRatingProvider;
            },
            onProviderReady1: (ShopRatingProvider provider) {
              provider.loadShopRatingList(widget.shopInfoId);
            },
            initProvider2: () {
              shopInfoProvider = ShopInfoProvider(
                  ownerCode: null,
                  psValueHolder: psValueHolder,
                  repo: shopInfoRepository);
              return shopInfoProvider;
            },
            onProviderReady2: (ShopInfoProvider shopInfoProvider) {
              shopInfoProvider.loadShopInfo(widget.shopInfoId);
            },
            child: Consumer<ShopRatingProvider>(builder: (BuildContext context,
                ShopRatingProvider shopRatingProvider, Widget child) {
              return Container(
                color: PsColors.coreBackgroundColor,
                child: RefreshIndicator(
                  child: CustomScrollView(
                    physics: const AlwaysScrollableScrollPhysics(),
                    slivers: <Widget>[
                      const SliverToBoxAdapter(
                        child: PsAdMobBannerWidget(),
                      ),
                      HeaderWidget(
                          productDetailId: widget.shopInfoId,
                          shopRatingProvider: shopRatingProvider),
                      SliverList(
                        delegate: SliverChildBuilderDelegate(
                          (BuildContext context, int index) {
                            return ShopRatingListItem(
                              rating: shopRatingProvider.ratingList.data[index],
                              onTap: () {},
                            );
                          },
                          childCount: shopRatingProvider.ratingList.data.length,
                        ),
                      )
                    ],
                  ),
                  onRefresh: () {
                    return shopRatingProvider
                        .refreshShopRatingList(widget.shopInfoId);
                  },
                ),
              );
            })));
  }
}

class HeaderWidget extends StatefulWidget {
  const HeaderWidget(
      {Key key,
      @required this.productDetailId,
      @required this.shopRatingProvider})
      : super(key: key);
  final String productDetailId;
  final ShopRatingProvider shopRatingProvider;

  @override
  _HeaderWidgetState createState() => _HeaderWidgetState();
}

class _HeaderWidgetState extends State<HeaderWidget> {
  ProductRepository repo;
  PsValueHolder psValueHolder;

  @override
  Widget build(BuildContext context) {
    repo = Provider.of<ProductRepository>(context);
    psValueHolder = Provider.of<PsValueHolder>(context);

    const Widget _spacingWidget = SizedBox(
      height: PsDimens.space10,
    );
    return SliverToBoxAdapter(
      child: Consumer<ShopInfoProvider>(builder: (BuildContext context,
          ShopInfoProvider shopInfoProvider, Widget child) {
        if (shopInfoProvider.shopInfo != null &&
            shopInfoProvider.shopInfo.data != null &&
            shopInfoProvider.shopInfo.data.ratingDetail != null) {
          return Container(
            color: PsColors.backgroundColor,
            child: Padding(
              padding: const EdgeInsets.only(
                  left: PsDimens.space12,
                  right: PsDimens.space12,
                  bottom: PsDimens.space8),
              child: Column(
                mainAxisAlignment: MainAxisAlignment.start,
                crossAxisAlignment: CrossAxisAlignment.start,
                children: <Widget>[
                  _spacingWidget,
                  Text(
                      '${shopInfoProvider.shopInfo.data.ratingDetail.totalRatingCount} ${Utils.getString(context, 'rating_list__customer_reviews')}'),
                  const SizedBox(
                    height: PsDimens.space4,
                  ),
                  Row(
                    children: <Widget>[
                      SmoothStarRating(
                          key: Key(shopInfoProvider
                              .shopInfo.data.ratingDetail.totalRatingValue),
                          rating: double.parse(shopInfoProvider
                              .shopInfo.data.ratingDetail.totalRatingValue),
                          allowHalfRating: false,
                          isReadOnly: true,
                          starCount: 5,
                          size: PsDimens.space16,
                          color: PsColors.ratingColor,
                          borderColor: PsColors.grey.withAlpha(100),
                          spacing: 0.0),
                      const SizedBox(
                        width: PsDimens.space100,
                      ),
                      Text(
                          '${shopInfoProvider.shopInfo.data.ratingDetail.totalRatingValue} ${Utils.getString(context, 'rating_list__out_of_five_stars')}'),
                    ],
                  ),
                  _RatingWidget(
                      starCount:
                          Utils.getString(context, 'rating_list__five_star'),
                      value: double.parse(shopInfoProvider
                          .shopInfo.data.ratingDetail.fiveStarCount),
                      percentage:
                          '${shopInfoProvider.shopInfo.data.ratingDetail.fiveStarPercent} ${Utils.getString(context, 'rating_list__percent')}'),
                  _RatingWidget(
                      starCount:
                          Utils.getString(context, 'rating_list__four_star'),
                      value: double.parse(shopInfoProvider
                          .shopInfo.data.ratingDetail.fourStarCount),
                      percentage:
                          '${shopInfoProvider.shopInfo.data.ratingDetail.fourStarPercent} ${Utils.getString(context, 'rating_list__percent')}'),
                  _RatingWidget(
                      starCount:
                          Utils.getString(context, 'rating_list__three_star'),
                      value: double.parse(shopInfoProvider
                          .shopInfo.data.ratingDetail.threeStarCount),
                      percentage:
                          '${shopInfoProvider.shopInfo.data.ratingDetail.threeStarPercent} ${Utils.getString(context, 'rating_list__percent')}'),
                  _RatingWidget(
                      starCount:
                          Utils.getString(context, 'rating_list__two_star'),
                      value: double.parse(shopInfoProvider
                          .shopInfo.data.ratingDetail.twoStarCount),
                      percentage:
                          '${shopInfoProvider.shopInfo.data.ratingDetail.twoStarPercent} ${Utils.getString(context, 'rating_list__percent')}'),
                  _RatingWidget(
                      starCount:
                          Utils.getString(context, 'rating_list__one_star'),
                      value: double.parse(shopInfoProvider
                          .shopInfo.data.ratingDetail.oneStarCount),
                      percentage:
                          '${shopInfoProvider.shopInfo.data.ratingDetail.oneStarPercent} ${Utils.getString(context, 'rating_list__percent')}'),
                  _spacingWidget,
                  const Divider(
                    height: PsDimens.space1,
                  ),
                  _WriteReviewButtonWidget(
                    shopInfoProvider: shopInfoProvider,
                    shopRatingProvider: widget.shopRatingProvider,
                    shopId: widget.productDetailId,
                  ),
                  const SizedBox(
                    height: PsDimens.space12,
                  ),
                ],
              ),
            ),
          );
        } else {
          return Container();
        }
      }),
    );
  }
}

class _RatingWidget extends StatelessWidget {
  const _RatingWidget({
    Key key,
    @required this.starCount,
    @required this.value,
    @required this.percentage,
  }) : super(key: key);

  final String starCount;
  final double value;
  final String percentage;

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: const EdgeInsets.only(top: PsDimens.space4),
      width: MediaQuery.of(context).size.width,
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        mainAxisSize: MainAxisSize.max,
        children: <Widget>[
          Text(
            starCount,
            style: Theme.of(context).textTheme.subtitle2,
          ),
          const SizedBox(
            width: PsDimens.space12,
          ),
          Expanded(
            flex: 5,
            child: LinearProgressIndicator(
              value: value,
            ),
          ),
          const SizedBox(
            width: PsDimens.space12,
          ),
          Container(
            width: PsDimens.space68,
            child: Text(
              percentage,
              style: Theme.of(context).textTheme.bodyText2,
            ),
          ),
        ],
      ),
    );
  }
}

class _WriteReviewButtonWidget extends StatelessWidget {
  const _WriteReviewButtonWidget({
    Key key,
    @required this.shopInfoProvider,
    @required this.shopRatingProvider,
    @required this.shopId,
  }) : super(key: key);

  final ShopInfoProvider shopInfoProvider;
  final ShopRatingProvider shopRatingProvider;
  final String shopId;

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: const EdgeInsets.only(top: PsDimens.space10),
      alignment: Alignment.bottomCenter,
      child: SizedBox(
        width: double.infinity,
        height: PsDimens.space36,
        child: PSButtonWidget(
          hasShadow: true,
          width: double.infinity,
          titleText: Utils.getString(context, 'rating_list__write_review'),
          onPressed: () async {
            if (await Utils.checkInternetConnectivity()) {
              Utils.navigateOnUserVerificationView(context, () async {
                await showDialog<dynamic>(
                    context: context,
                    builder: (BuildContext context) {
                      return ShopRatingInputDialog(
                          shopInfoProvider: shopInfoProvider);
                    });

                shopRatingProvider.refreshShopRatingList(shopId);
                await shopInfoProvider.loadShopInfo(shopId);
              });
            } else {
              showDialog<dynamic>(
                  context: context,
                  builder: (BuildContext context) {
                    return ErrorDialog(
                      message:
                          Utils.getString(context, 'error_dialog__no_internet'),
                    );
                  });
            }
          },
        ),
      ),
    );
  }
}
