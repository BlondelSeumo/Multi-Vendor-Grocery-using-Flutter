import 'package:flutter/material.dart';
import 'package:flutter_native_admob/flutter_native_admob.dart';
import 'package:fluttermultigrocery/api/common/ps_status.dart';
import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/config/ps_config.dart';
import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/constant/route_paths.dart';
import 'package:fluttermultigrocery/provider/category/category_provider.dart';
import 'package:fluttermultigrocery/provider/product/discount_product_provider.dart';
import 'package:fluttermultigrocery/provider/product/search_product_provider.dart';
import 'package:fluttermultigrocery/provider/product/trending_product_provider.dart';
import 'package:fluttermultigrocery/provider/shop/new_shop_provider.dart';
import 'package:fluttermultigrocery/provider/shop/trending_shop_provider.dart';
import 'package:fluttermultigrocery/repository/category_repository.dart';
import 'package:fluttermultigrocery/repository/product_collection_repository.dart';
import 'package:fluttermultigrocery/repository/product_repository.dart';
import 'package:fluttermultigrocery/repository/shop_info_repository.dart';
import 'package:fluttermultigrocery/repository/shop_repository.dart';
import 'package:fluttermultigrocery/ui/category/item/category_horizontal_list_item.dart';
import 'package:fluttermultigrocery/ui/common/ps_admob_banner_widget.dart';
import 'package:fluttermultigrocery/ui/common/ps_frame_loading_widget.dart';
import 'package:fluttermultigrocery/ui/map/home_location_view.dart';
import 'package:fluttermultigrocery/ui/product/item/product_horizontal_list_item.dart';
import 'package:fluttermultigrocery/ui/shop_list/item/shop_horizontal_list_item.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_value_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/product_detail_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/product_list_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/shop_data_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/shop_list_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/product_parameter_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/shop_parameter_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/touch_count_parameter_holder.dart';
import 'package:fluttermultigrocery/viewobject/product.dart';
import 'package:fluttermultigrocery/viewobject/product_collection_header.dart';
import 'package:provider/provider.dart';
import 'package:provider/single_child_widget.dart';
import 'package:shimmer/shimmer.dart';

class MainDashboardViewWidget extends StatefulWidget {
  const MainDashboardViewWidget(
    this.animationController,
    this.context,
  );

  final AnimationController animationController;
  final BuildContext context;

  @override
  _MainDashboardViewWidgetState createState() =>
      _MainDashboardViewWidgetState();
}

class _MainDashboardViewWidgetState extends State<MainDashboardViewWidget> {
  PsValueHolder valueHolder;
  CategoryRepository repo1;
  ProductRepository repo2;
  ProductCollectionRepository repo3;
  ShopInfoRepository shopInfoRepository;
  TrendingShopProvider trendingShopProvider;
  NewShopProvider newShopProvider;
  ShopRepository shopRepository;
  TextEditingController searchTextController = TextEditingController();
  TextEditingController addressController = TextEditingController();
  TrendingProductProvider _trendingProductProvider;
  DiscountProductProvider _discountProductProvider;
  CategoryProvider _categoryProvider;
  final int count = 8;

  @override
  void initState() {
    super.initState();
    if (_categoryProvider != null) {
      _categoryProvider
          .loadCategoryList(_categoryProvider.latestCategoryParameterHolder);
    }
  }

  @override
  Widget build(BuildContext context) {
    repo1 = Provider.of<CategoryRepository>(context);
    repo2 = Provider.of<ProductRepository>(context);
    repo3 = Provider.of<ProductCollectionRepository>(context);
    shopInfoRepository = Provider.of<ShopInfoRepository>(context);
    shopRepository = Provider.of<ShopRepository>(context);

    valueHolder = Provider.of<PsValueHolder>(context);

    return MultiProvider(
        providers: <SingleChildWidget>[
          ChangeNotifierProvider<NewShopProvider>(
              lazy: false,
              create: (BuildContext context) {
                newShopProvider = NewShopProvider(
                    repo: shopRepository, limit: PsConfig.SHOP_LOADING_LIMIT);
                return newShopProvider;
              }),
          ChangeNotifierProvider<CategoryProvider>(
              lazy: false,
              create: (BuildContext context) {
                _categoryProvider ??= CategoryProvider(
                    repo: repo1,
                    psValueHolder: valueHolder,
                    limit: PsConfig.CATEGORY_LOADING_LIMIT);
                _categoryProvider.loadCategoryList(
                    _categoryProvider.latestCategoryParameterHolder);
                return _categoryProvider;
              }),
          ChangeNotifierProvider<SearchProductProvider>(
              lazy: false,
              create: (BuildContext context) {
                final SearchProductProvider provider = SearchProductProvider(
                    repo: repo2, limit: PsConfig.LATEST_PRODUCT_LOADING_LIMIT);
                // provider.latestProductParameterHolder.shopId = widget.shopId;
                provider.loadProductListByKey(
                    provider.latestProductParameterHolder);
                return provider;
              }),
          ChangeNotifierProvider<DiscountProductProvider>(
              lazy: false,
              create: (BuildContext context) {
                _discountProductProvider = DiscountProductProvider(
                    repo: repo2,
                    limit: PsConfig.DISCOUNT_PRODUCT_LOADING_LIMIT);
                // provider.discountProductParameterHolder.shopId = widget.shopId;
                _discountProductProvider.loadProductList(
                    _discountProductProvider.discountProductParameterHolder);
                return _discountProductProvider;
              }),
          ChangeNotifierProvider<TrendingProductProvider>(
              lazy: false,
              create: (BuildContext context) {
                _trendingProductProvider = TrendingProductProvider(
                    repo: repo2,
                    limit: PsConfig.TRENDING_PRODUCT_LOADING_LIMIT);
                // provider.trendingProductParameterHolder.shopId = widget.shopId;
                _trendingProductProvider.loadProductList(
                    _trendingProductProvider.trendingProductParameterHolder);
                return _trendingProductProvider;
              }),
          ChangeNotifierProvider<TrendingShopProvider>(
              lazy: false,
              create: (BuildContext context) {
                trendingShopProvider = TrendingShopProvider(
                    repo: shopRepository, limit: PsConfig.SHOP_LOADING_LIMIT);
                trendingShopProvider.loadShopList();
                return trendingShopProvider;
              }),
        ],
        child: Container(
          color: PsColors.baseLightColor,
          child: RefreshIndicator(
            onRefresh: () {
              _trendingProductProvider.resetTrendingProductList(
                  _trendingProductProvider.trendingProductParameterHolder);
              _discountProductProvider.resetDiscountProductList(
                  _discountProductProvider.discountProductParameterHolder);
              trendingShopProvider.refreshShopList();
              return _categoryProvider.resetCategoryList(
                  _categoryProvider.latestCategoryParameterHolder);
            },
            child: CustomScrollView(
              physics: const AlwaysScrollableScrollPhysics(),
              scrollDirection: Axis.vertical,
              slivers: <Widget>[
                SliverToBoxAdapter(
                    child: HomeLocationWidget(
                        androidFusedLocation: true,
                        textEditingController: addressController,
                        // newShopProvider : newShopProvider,
                        searchTextController: searchTextController,
                        valueHolder: valueHolder)),

                ///
                /// category List Widget
                ///
                _HomeCategoryHorizontalListWidget(
                  psValueHolder: valueHolder,
                  animationController:
                      widget.animationController, //animationController,
                  animation: Tween<double>(begin: 0.0, end: 1.0).animate(
                      CurvedAnimation(
                          parent: widget.animationController,
                          curve: Interval((1 / count) * 2, 1.0,
                              curve: Curves.fastOutSlowIn))), //animation
                ),
                _HomeNewShopHorizontalListWidget(
                  psValueHolder: valueHolder,
                  animationController:
                      widget.animationController, //animationController,
                  animation: Tween<double>(begin: 0.0, end: 1.0).animate(
                      CurvedAnimation(
                          parent: widget.animationController,
                          curve: Interval((1 / count) * 4, 1.0,
                              curve: Curves.fastOutSlowIn))), //animation
                ),
                _HomeTrendingProductHorizontalListWidget(
                  animationController:
                      widget.animationController, //animationController,
                  animation: Tween<double>(begin: 0.0, end: 1.0).animate(
                      CurvedAnimation(
                          parent: widget.animationController,
                          curve: Interval((1 / count) * 4, 1.0,
                              curve: Curves.fastOutSlowIn))), //animation
                ),
                _DiscountProductHorizontalListWidget(
                  animationController:
                      widget.animationController, //animationController,
                  animation: Tween<double>(begin: 0.0, end: 1.0).animate(
                      CurvedAnimation(
                          parent: widget.animationController,
                          curve: Interval((1 / count) * 3, 1.0,
                              curve: Curves.fastOutSlowIn))), //animation
                ),
                _HomePopularShopHorizontalListWidget(
                  psValueHolder: valueHolder,
                  animationController:
                      widget.animationController, //animationController,
                  animation: Tween<double>(begin: 0.0, end: 1.0).animate(
                      CurvedAnimation(
                          parent: widget.animationController,
                          curve: Interval((1 / count) * 6, 1.0,
                              curve: Curves.fastOutSlowIn))), //animation
                ),
              ],
            ),
          ),
        ));
  }
}

class _HomeNewShopHorizontalListWidget extends StatefulWidget {
  const _HomeNewShopHorizontalListWidget(
      {Key key,
      @required this.animationController,
      @required this.animation,
      @required this.psValueHolder})
      : super(key: key);

  final AnimationController animationController;
  final Animation<double> animation;
  final PsValueHolder psValueHolder;

  @override
  __HomeNewShopHorizontalListWidgetState createState() =>
      __HomeNewShopHorizontalListWidgetState();
}

class __HomeNewShopHorizontalListWidgetState
    extends State<_HomeNewShopHorizontalListWidget> {
  bool isConnectedToInternet = false;
  bool isSuccessfullyLoaded = true;

  void checkConnection() {
    Utils.checkInternetConnectivity().then((bool onValue) {
      isConnectedToInternet = onValue;
      if (isConnectedToInternet && PsConst.SHOW_ADMOB) {
        setState(() {});
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    if (!isConnectedToInternet && PsConst.SHOW_ADMOB) {
      print('loading ads....');
      checkConnection();
    }
    return SliverToBoxAdapter(
      child: Consumer<NewShopProvider>(
        builder: (BuildContext context, NewShopProvider newShopProvider,
            Widget child) {
          return AnimatedBuilder(
              animation: widget.animationController,
              child: (newShopProvider.shopList.data != null &&
                      newShopProvider.shopList.data.isNotEmpty)
                  ? Column(children: <Widget>[
                      Container(
                        color: PsColors.backgroundColor,
                        child: _MyHeaderWidget(
                          headerName: Utils.getString(
                              context, 'shop_dashboard__shop_near_you'),
                          viewAllClicked: () {
                            Navigator.pushNamed(context, RoutePaths.shopList,
                                arguments: ShopListIntentHolder(
                                  appBarTitle: Utils.getString(
                                      context, 'shop_dashboard__shop_near_you'),
                                  shopParameterHolder: newShopProvider
                                      .shopNearYouParameterHolder,
                                ));
                          },
                        ),
                      ),
                      // Padding(
                      //   padding: const EdgeInsets.only(
                      //       left: PsDimens.space16,
                      //       right: PsDimens.space16,
                      //       bottom: PsDimens.space16),
                      // child:
                      Container(
                          color: PsColors.backgroundColor,
                          height: PsDimens.space320,
                          width: MediaQuery.of(context).size.width,
                          child: ListView.builder(
                              scrollDirection: Axis.horizontal,
                              padding:
                                  const EdgeInsets.only(left: PsDimens.space16),
                              itemCount: newShopProvider.shopList.data.length,
                              itemBuilder: (BuildContext context, int index) {
                                if (newShopProvider.shopList.status ==
                                    PsStatus.BLOCK_LOADING) {
                                  return Shimmer.fromColors(
                                      baseColor: PsColors.grey,
                                      highlightColor: PsColors.white,
                                      child: Row(children: const <Widget>[
                                        PsFrameUIForLoading(),
                                      ]));
                                } else {
                                  return ShopHorizontalListItem(
                                    shop: newShopProvider.shopList.data[index],
                                    onTap: () {
                                      final String loginUserId =
                                          Utils.checkUserLoginId(
                                              widget.psValueHolder);

                                      final TouchCountParameterHolder
                                          touchCountParameterHolder =
                                          TouchCountParameterHolder(
                                              typeId: newShopProvider
                                                  .shopList.data[index].id,
                                              typeName: PsConst
                                                  .FILTERING_TYPE_NAME_SHOP,
                                              userId: loginUserId,
                                              shopId: newShopProvider
                                                  .shopList.data[index].id);
                                      newShopProvider.postTouchCount(
                                          touchCountParameterHolder.toMap());

                                      newShopProvider.replaceShop(
                                          newShopProvider
                                              .shopList.data[index].id,
                                          newShopProvider
                                              .shopList.data[index].name);
                                      Navigator.pushNamed(
                                          context, RoutePaths.shop_dashboard,
                                          arguments: ShopDataIntentHolder(
                                              shopId: newShopProvider
                                                  .shopList.data[index].id,
                                              shopName: newShopProvider
                                                  .shopList.data[index].name));
                                    },
                                  );
                                }
                              })),
                      const SizedBox(height: PsDimens.space8),
                      // ),
                      const PsAdMobBannerWidget(
                        admobSize: NativeAdmobType.full,
                      ),
                    ])
                  : Container(),
              builder: (BuildContext context, Widget child) {
                return FadeTransition(
                  opacity: widget.animation,
                  child: Transform(
                    transform: Matrix4.translationValues(
                        0.0, 100 * (1.0 - widget.animation.value), 0.0),
                    child: child,
                  ),
                );
              });
        },
      ),
    );
  }
}

class _HomePopularShopHorizontalListWidget extends StatefulWidget {
  const _HomePopularShopHorizontalListWidget(
      {Key key,
      @required this.animationController,
      @required this.animation,
      @required this.psValueHolder})
      : super(key: key);

  final AnimationController animationController;
  final Animation<double> animation;
  final PsValueHolder psValueHolder;

  @override
  __HomePopularShopHorizontalListWidgetState createState() =>
      __HomePopularShopHorizontalListWidgetState();
}

class __HomePopularShopHorizontalListWidgetState
    extends State<_HomePopularShopHorizontalListWidget> {
  @override
  Widget build(BuildContext context) {
    return SliverToBoxAdapter(
      child: Consumer<TrendingShopProvider>(
        builder: (BuildContext context, TrendingShopProvider shopProvider,
            Widget child) {
          return AnimatedBuilder(
            animation: widget.animationController,
            child: (shopProvider.shopList.data != null &&
                    shopProvider.shopList.data.isNotEmpty)
                ? Column(children: <Widget>[
                    Container(
                      color: PsColors.backgroundColor,
                      child: _MyHeaderWidget(
                        headerName: Utils.getString(
                            context, 'shop_dashboard__trending_shop'),
                        viewAllClicked: () {
                          Navigator.pushNamed(context, RoutePaths.shopList,
                              arguments: ShopListIntentHolder(
                                appBarTitle: Utils.getString(
                                    context, 'shop_dashboard__trending_shop'),
                                shopParameterHolder: ShopParameterHolder()
                                    .getTrendingShopParameterHolder(),
                              ));
                        },
                      ),
                    ),
                    // Padding(
                    //   padding: const EdgeInsets.only(
                    //       left: PsDimens.space16,
                    //       right: PsDimens.space16,
                    //       bottom: PsDimens.space16),
                    //   child:
                    Container(
                        color: PsColors.backgroundColor,
                        height: 900,
                        width: MediaQuery.of(context).size.width,
                        child: RefreshIndicator(
                          child: CustomScrollView(
                            physics: const AlwaysScrollableScrollPhysics(),
                            scrollDirection: Axis.horizontal,
                            shrinkWrap: true,
                            slivers: <Widget>[
                              SliverPadding(
                                  padding: const EdgeInsets.fromLTRB(
                                      PsDimens.space16, 0, PsDimens.space16, 0),
                                  sliver: SliverGrid(
                                      gridDelegate:
                                          const SliverGridDelegateWithMaxCrossAxisExtent(
                                              maxCrossAxisExtent: 350,
                                              childAspectRatio: 1.0),
                                      delegate: SliverChildBuilderDelegate(
                                        (BuildContext context, int index) {
                                          if (shopProvider.shopList.status ==
                                              PsStatus.BLOCK_LOADING) {
                                            return Shimmer.fromColors(
                                                baseColor: PsColors.grey,
                                                highlightColor: PsColors.white,
                                                child: Row(
                                                    children: const <Widget>[
                                                      PsFrameUIForLoading(),
                                                    ]));
                                          } else {
                                            return ShopHorizontalListItem(
                                              shop: shopProvider
                                                  .shopList.data[index],
                                              onTap: () async {
                                                final String loginUserId =
                                                    Utils.checkUserLoginId(
                                                        widget.psValueHolder);

                                                final TouchCountParameterHolder
                                                    touchCountParameterHolder =
                                                    TouchCountParameterHolder(
                                                        typeId: shopProvider
                                                            .shopList
                                                            .data[index]
                                                            .id,
                                                        typeName: PsConst
                                                            .FILTERING_TYPE_NAME_SHOP,
                                                        userId: loginUserId,
                                                        shopId: shopProvider
                                                            .shopList
                                                            .data[index]
                                                            .id);
                                                shopProvider.postTouchCount(
                                                    touchCountParameterHolder
                                                        .toMap());

                                                shopProvider.replaceShop(
                                                    shopProvider.shopList
                                                        .data[index].id,
                                                    shopProvider.shopList
                                                        .data[index].name);
                                                final dynamic result =
                                                    await Navigator.pushNamed(
                                                        context,
                                                        RoutePaths
                                                            .shop_dashboard,
                                                        arguments:
                                                            ShopDataIntentHolder(
                                                                shopId:
                                                                    shopProvider
                                                                        .shopList
                                                                        .data[
                                                                            index]
                                                                        .id,
                                                                shopName:
                                                                    shopProvider
                                                                        .shopList
                                                                        .data[
                                                                            index]
                                                                        .name));

                                                if (result != null && result) {
                                                  setState(() {
                                                    shopProvider
                                                        .refreshShopList();
                                                  });
                                                }
                                              },
                                            );
                                          }
                                        },
                                        childCount:
                                            shopProvider.shopList.data.length,
                                      )))
                            ],
                          ),
                          onRefresh: () {
                            return shopProvider.refreshShopList();
                          },
                        )),
                    const SizedBox(height: PsDimens.space8),
                    // )
                  ])
                : Container(),
            builder: (BuildContext context, Widget child) {
              return FadeTransition(
                opacity: widget.animation,
                child: Transform(
                  transform: Matrix4.translationValues(
                      0.0, 100 * (1.0 - widget.animation.value), 0.0),
                  child: child,
                ),
              );
            },
          );
        },
      ),
    );
  }
}

class _HomeTrendingProductHorizontalListWidget extends StatelessWidget {
  const _HomeTrendingProductHorizontalListWidget({
    Key key,
    @required this.animationController,
    @required this.animation,
  }) : super(key: key);

  final AnimationController animationController;
  final Animation<double> animation;

  @override
  Widget build(BuildContext context) {
    return SliverToBoxAdapter(
      child: Consumer<TrendingProductProvider>(
        builder: (BuildContext context, TrendingProductProvider productProvider,
            Widget child) {
          return AnimatedBuilder(
            animation: animationController,
            child: (productProvider.productList.data != null &&
                    productProvider.productList.data.isNotEmpty)
                ? Column(
                    children: <Widget>[
                      Container(
                        color: PsColors.backgroundColor,
                        child: _MyHeaderWidget(
                          headerName: Utils.getString(
                              context, 'dashboard__trending_product'),
                          viewAllClicked: () {
                            Navigator.pushNamed(
                                context, RoutePaths.filterProductList,
                                arguments: ProductListIntentHolder(
                                    appBarTitle: Utils.getString(
                                        context, 'dashboard__trending_product'),
                                    productParameterHolder:
                                        ProductParameterHolder()
                                            .getTrendingParameterHolder()));
                          },
                        ),
                      ),
                      Container(
                          color: PsColors.backgroundColor,
                          height: PsDimens.space320,
                          width: MediaQuery.of(context).size.width,
                          child: ListView.builder(
                              scrollDirection: Axis.horizontal,
                              itemCount:
                                  productProvider.productList.data.length,
                              padding:
                                  const EdgeInsets.only(left: PsDimens.space16),
                              itemBuilder: (BuildContext context, int index) {
                                if (productProvider.productList.status ==
                                    PsStatus.BLOCK_LOADING) {
                                  return Shimmer.fromColors(
                                      baseColor: PsColors.grey,
                                      highlightColor: PsColors.white,
                                      child: Row(children: const <Widget>[
                                        PsFrameUIForLoading(),
                                      ]));
                                } else {
                                  final Product product =
                                      productProvider.productList.data[index];
                                  return ProductHorizontalListItem(
                                    coreTagKey:
                                        productProvider.hashCode.toString() +
                                            product.id,
                                    product:
                                        productProvider.productList.data[index],
                                    onTap: () {
                                      print(productProvider.productList
                                          .data[index].defaultPhoto.imgPath);
                                      final ProductDetailIntentHolder holder =
                                          ProductDetailIntentHolder(
                                        product: productProvider
                                            .productList.data[index],
                                        heroTagImage: productProvider.hashCode
                                                .toString() +
                                            product.id +
                                            PsConst.HERO_TAG__IMAGE,
                                        heroTagTitle: productProvider.hashCode
                                                .toString() +
                                            product.id +
                                            PsConst.HERO_TAG__TITLE,
                                        heroTagOriginalPrice: productProvider
                                                .hashCode
                                                .toString() +
                                            product.id +
                                            PsConst.HERO_TAG__ORIGINAL_PRICE,
                                        heroTagUnitPrice: productProvider
                                                .hashCode
                                                .toString() +
                                            product.id +
                                            PsConst.HERO_TAG__UNIT_PRICE,
                                      );
                                      Navigator.pushNamed(
                                          context, RoutePaths.productDetail,
                                          arguments: holder);
                                    },
                                  );
                                }
                              })),
                      const SizedBox(height: PsDimens.space8),
                    ],
                  )
                : Container(),
            builder: (BuildContext context, Widget child) {
              return FadeTransition(
                opacity: animation,
                child: Transform(
                  transform: Matrix4.translationValues(
                      0.0, 100 * (1.0 - animation.value), 0.0),
                  child: child,
                ),
              );
            },
          );
        },
      ),
    );
  }
}

class _DiscountProductHorizontalListWidget extends StatefulWidget {
  const _DiscountProductHorizontalListWidget({
    Key key,
    @required this.animationController,
    @required this.animation,
  }) : super(key: key);

  final AnimationController animationController;
  final Animation<double> animation;

  @override
  __DiscountProductHorizontalListWidgetState createState() =>
      __DiscountProductHorizontalListWidgetState();
}

class __DiscountProductHorizontalListWidgetState
    extends State<_DiscountProductHorizontalListWidget> {
  bool isConnectedToInternet = false;
  bool isSuccessfullyLoaded = true;

  void checkConnection() {
    Utils.checkInternetConnectivity().then((bool onValue) {
      isConnectedToInternet = onValue;
      if (isConnectedToInternet && PsConst.SHOW_ADMOB) {
        setState(() {});
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    if (!isConnectedToInternet && PsConst.SHOW_ADMOB) {
      print('loading ads....');
      checkConnection();
    }
    return SliverToBoxAdapter(
        // fdfdf
        child: Consumer<DiscountProductProvider>(builder: (BuildContext context,
            DiscountProductProvider productProvider, Widget child) {
      return AnimatedBuilder(
          animation: widget.animationController,
          child: (productProvider.productList.data != null &&
                  productProvider.productList.data.isNotEmpty)
              ? Column(children: <Widget>[
                  Container(
                    color: PsColors.backgroundColor,
                    child: _MyHeaderWidget(
                      headerName: Utils.getString(
                          context, 'dashboard__discount_product'),
                      viewAllClicked: () {
                        Navigator.pushNamed(
                            context, RoutePaths.filterProductList,
                            arguments: ProductListIntentHolder(
                                appBarTitle: Utils.getString(
                                    context, 'dashboard__discount_product'),
                                productParameterHolder: ProductParameterHolder()
                                    .getDiscountParameterHolder()));
                      },
                    ),
                  ),
                  Container(
                      color: PsColors.backgroundColor,
                      height: PsDimens.space320,
                      width: MediaQuery.of(context).size.width,
                      child: ListView.builder(
                          scrollDirection: Axis.horizontal,
                          padding:
                              const EdgeInsets.only(left: PsDimens.space16),
                          itemCount: productProvider.productList.data.length,
                          itemBuilder: (BuildContext context, int index) {
                            if (productProvider.productList.status ==
                                PsStatus.BLOCK_LOADING) {
                              return Shimmer.fromColors(
                                  baseColor: PsColors.grey,
                                  highlightColor: PsColors.white,
                                  child: Row(children: const <Widget>[
                                    PsFrameUIForLoading(),
                                  ]));
                            } else {
                              final Product product =
                                  productProvider.productList.data[index];
                              return ProductHorizontalListItem(
                                coreTagKey:
                                    productProvider.hashCode.toString() +
                                        product.id,
                                product:
                                    productProvider.productList.data[index],
                                onTap: () {
                                  print(productProvider.productList.data[index]
                                      .defaultPhoto.imgPath);
                                  final ProductDetailIntentHolder holder =
                                      ProductDetailIntentHolder(
                                    product:
                                        productProvider.productList.data[index],
                                    heroTagImage:
                                        productProvider.hashCode.toString() +
                                            product.id +
                                            PsConst.HERO_TAG__IMAGE,
                                    heroTagTitle:
                                        productProvider.hashCode.toString() +
                                            product.id +
                                            PsConst.HERO_TAG__TITLE,
                                    heroTagOriginalPrice:
                                        productProvider.hashCode.toString() +
                                            product.id +
                                            PsConst.HERO_TAG__ORIGINAL_PRICE,
                                    heroTagUnitPrice:
                                        productProvider.hashCode.toString() +
                                            product.id +
                                            PsConst.HERO_TAG__UNIT_PRICE,
                                  );
                                  Navigator.pushNamed(
                                      context, RoutePaths.productDetail,
                                      arguments: holder);
                                },
                              );
                            }
                          })),
                  const SizedBox(height: PsDimens.space8),
                  const PsAdMobBannerWidget(
                    admobSize: NativeAdmobType.full,
                  ),
                ])
              : Container(),
          builder: (BuildContext context, Widget child) {
            return FadeTransition(
                opacity: widget.animation,
                child: Transform(
                  transform: Matrix4.translationValues(
                      0.0, 100 * (1.0 - widget.animation.value), 0.0),
                  child: child,
                ));
          });
    }));
  }
}

class _HomeCategoryHorizontalListWidget extends StatefulWidget {
  const _HomeCategoryHorizontalListWidget(
      {Key key,
      @required this.animationController,
      @required this.animation,
      @required this.psValueHolder})
      : super(key: key);

  final AnimationController animationController;
  final Animation<double> animation;
  final PsValueHolder psValueHolder;

  @override
  __HomeCategoryHorizontalListWidgetState createState() =>
      __HomeCategoryHorizontalListWidgetState();
}

class __HomeCategoryHorizontalListWidgetState
    extends State<_HomeCategoryHorizontalListWidget> {
  @override
  Widget build(BuildContext context) {
    return SliverToBoxAdapter(child: Consumer<CategoryProvider>(
      builder: (BuildContext context, CategoryProvider categoryProvider,
          Widget child) {
        return AnimatedBuilder(
            animation: widget.animationController,
            child: (categoryProvider.categoryList.data != null &&
                    categoryProvider.categoryList.data.isNotEmpty)
                ? Column(children: <Widget>[
                    Container(
                      color: PsColors.backgroundColor,
                      height: PsDimens.space140,
                      width: MediaQuery.of(context).size.width,
                      child: ListView.builder(
                          shrinkWrap: true,
                          padding:
                              const EdgeInsets.only(left: PsDimens.space16),
                          scrollDirection: Axis.horizontal,
                          itemCount: categoryProvider.categoryList.data.length,
                          itemBuilder: (BuildContext context, int index) {
                            if (categoryProvider.categoryList.status ==
                                PsStatus.BLOCK_LOADING) {
                              return Shimmer.fromColors(
                                  baseColor: PsColors.grey,
                                  highlightColor: PsColors.white,
                                  child: Row(children: const <Widget>[
                                    PsFrameUIForLoading(),
                                  ]));
                            } else {
                              return CategoryHorizontalListItem(
                                category:
                                    categoryProvider.categoryList.data[index],
                                onTap: () {
                                  final String loginUserId =
                                      Utils.checkUserLoginId(
                                          widget.psValueHolder);
                                  final TouchCountParameterHolder
                                      touchCountParameterHolder =
                                      TouchCountParameterHolder(
                                          typeId: categoryProvider
                                              .categoryList.data[index].id,
                                          typeName: PsConst
                                              .FILTERING_TYPE_NAME_CATEGORY,
                                          userId: loginUserId,
                                          shopId: '');

                                  categoryProvider.postTouchCount(
                                      touchCountParameterHolder.toMap());
                                  if (PsConfig.isShowSubCategory) {
                                    Navigator.pushNamed(
                                        context, RoutePaths.subCategoryGrid,
                                        arguments: categoryProvider
                                            .categoryList.data[index]);
                                  } else {
                                    final ProductParameterHolder
                                        productParameterHolder =
                                        ProductParameterHolder()
                                            .getLatestParameterHolder();
                                    productParameterHolder.catId =
                                        categoryProvider
                                            .categoryList.data[index].id;
                                    Navigator.pushNamed(
                                        context, RoutePaths.filterProductList,
                                        arguments: ProductListIntentHolder(
                                          appBarTitle: categoryProvider
                                              .categoryList.data[index].name,
                                          productParameterHolder:
                                              productParameterHolder,
                                        ));
                                  }
                                },
                                // )
                              );
                            }
                          }),
                    ),
                    const SizedBox(height: PsDimens.space8),
                  ])
                : Container(),
            builder: (BuildContext context, Widget child) {
              return FadeTransition(
                  opacity: widget.animation,
                  child: Transform(
                    transform: Matrix4.translationValues(
                        0.0, 30 * (1.0 - widget.animation.value), 0.0),
                    child: child,
                  ));
            });
      },
    ));
  }
}

class _MyHeaderWidget extends StatefulWidget {
  const _MyHeaderWidget({
    Key key,
    @required this.headerName,
    this.productCollectionHeader,
    @required this.viewAllClicked,
  }) : super(key: key);

  final String headerName;
  final Function viewAllClicked;
  final ProductCollectionHeader productCollectionHeader;

  @override
  __MyHeaderWidgetState createState() => __MyHeaderWidgetState();
}

class __MyHeaderWidgetState extends State<_MyHeaderWidget> {
  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: widget.viewAllClicked,
      child: Padding(
        padding: const EdgeInsets.only(
            top: PsDimens.space28,
            left: PsDimens.space20,
            right: PsDimens.space16,
            bottom: PsDimens.space16),
        child: Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          crossAxisAlignment: CrossAxisAlignment.end,
          children: <Widget>[
            Expanded(
              child: Text(widget.headerName,
                  style: Theme.of(context)
                      .textTheme
                      .headline5
                      .copyWith(color: PsColors.textPrimaryDarkColor)),
            ),
            Text(
              Utils.getString(context, 'dashboard__view_all'),
              textAlign: TextAlign.start,
              style: Theme.of(context)
                  .textTheme
                  .caption
                  .copyWith(color: PsColors.mainColor),
            ),
          ],
        ),
      ),
    );
  }
}
