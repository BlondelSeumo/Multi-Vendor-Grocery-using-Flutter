import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/config/ps_config.dart';
import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/provider/product/search_product_provider.dart';
import 'package:fluttermultigrocery/provider/shop_info/shop_info_provider.dart';
import 'package:fluttermultigrocery/repository/product_collection_repository.dart';
import 'package:fluttermultigrocery/repository/shop_info_repository.dart';
import 'package:fluttermultigrocery/ui/common/ps_ui_widget.dart';
import 'package:fluttermultigrocery/ui/dashboard/home/home_tabbar_slider.dart';
import 'package:fluttermultigrocery/ui/product/item/product_vertical_list_item.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/category.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_value_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/product_detail_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/product.dart';
import 'package:fluttermultigrocery/viewobject/product_collection_header.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:provider/single_child_widget.dart';
import 'package:fluttermultigrocery/api/common/ps_status.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/constant/route_paths.dart';
import 'package:fluttermultigrocery/provider/category/category_provider.dart';
import 'package:fluttermultigrocery/repository/category_repository.dart';
import 'package:fluttermultigrocery/repository/product_repository.dart';

class ShopDashboardView extends StatefulWidget {
  const ShopDashboardView({@required this.shopId, @required this.shopName});

  final String shopId;
  final String shopName;

  @override
  _ShopDashboardViewState createState() => _ShopDashboardViewState();
}

class _ShopDashboardViewState extends State<ShopDashboardView> {
  PsValueHolder valueHolder;
  CategoryRepository repo1;
  ProductRepository repo2;
  ProductCollectionRepository repo3;
  ShopInfoRepository shopInfoRepository;
  CategoryProvider _categoryProvider;
  final int count = 8;
  final TextEditingController userInputItemNameTextEditingController =
      TextEditingController();

  @override
  void initState() {
    super.initState();
    if (_categoryProvider != null) {
      _categoryProvider
          .loadCategoryList(_categoryProvider.latestCategoryParameterHolder);
    }
  }

  SearchProductProvider searchProductProvider;

  @override
  Widget build(BuildContext context) {
    repo1 = Provider.of<CategoryRepository>(context);
    repo2 = Provider.of<ProductRepository>(context);
    repo3 = Provider.of<ProductCollectionRepository>(context);
    shopInfoRepository = Provider.of<ShopInfoRepository>(context);
    valueHolder = Provider.of<PsValueHolder>(context);

    return MultiProvider(
      providers: <SingleChildWidget>[
        ChangeNotifierProvider<ShopInfoProvider>(
            lazy: false,
            create: (BuildContext context) {
              final ShopInfoProvider provider = ShopInfoProvider(
                  repo: shopInfoRepository,
                  psValueHolder: valueHolder,
                  ownerCode: 'ShopDashboardView');
              provider.loadShopInfo(widget.shopId);
              return provider;
            }),
        ChangeNotifierProvider<CategoryProvider>(
            lazy: false,
            create: (BuildContext context) {
              _categoryProvider ??= CategoryProvider(
                  repo: repo1,
                  psValueHolder: valueHolder,
                  limit: PsConfig.CATEGORY_LOADING_LIMIT);
              _categoryProvider.latestCategoryParameterHolder.shopId =
                  widget.shopId;
              _categoryProvider.loadCategoryList(
                  _categoryProvider.latestCategoryParameterHolder);
              return _categoryProvider;
            }),
      ],
      child: Container(
        // color: PsColors.white,
        child:

            ///
            /// category List Widget
            ///
            _HomeCategoryHorizontalListWidget(
                shopId: widget.shopId,
                shopName: widget.shopName,
                psValueHolder: valueHolder,
                // animationController: widget.animationController,
                userInputItemNameTextEditingController:
                    userInputItemNameTextEditingController), //animation
      ),
    );
  }
}

class _HomeLatestProductHorizontalListWidget extends StatefulWidget {
  const _HomeLatestProductHorizontalListWidget({
    Key key,
    @required this.animationController,
    @required this.animation,
    @required this.productProvider,
  }) : super(key: key);

  final AnimationController animationController;
  final Animation<double> animation;
  final SearchProductProvider productProvider;

  @override
  __HomeLatestProductHorizontalListWidgetState createState() =>
      __HomeLatestProductHorizontalListWidgetState();
}

class __HomeLatestProductHorizontalListWidgetState
    extends State<_HomeLatestProductHorizontalListWidget> {
  final ScrollController _scrollController = ScrollController();
  @override
  void dispose() {
    super.dispose();
  }

  @override
  void initState() {
    super.initState();

    _offset = 0;
    _scrollController.addListener(() {
      if (_scrollController.position.pixels ==
          _scrollController.position.maxScrollExtent) {
        widget.productProvider.nextProductListByKey(
            widget.productProvider.productParameterHolder);
      }
      setState(() {
        final double offset = _scrollController.offset;
        _delta += offset - _oldOffset;
        if (_delta > _containerMaxHeight)
          _delta = _containerMaxHeight;
        else if (_delta < 0) {
          _delta = 0;
        }
        _oldOffset = offset;
        _offset = -_delta;
      });

      print(' Offset $_offset');
    });
  }

  final double _containerMaxHeight = 60;
  double _offset, _delta = 0, _oldOffset = 0;
  @override
  Widget build(BuildContext context) {
    return Consumer<SearchProductProvider>(
      builder: (BuildContext context, SearchProductProvider productProvider,
          Widget child) {
        return AnimatedBuilder(
            animation: widget.animationController,
            builder: (BuildContext context, Widget child) {
              return Column(children: <Widget>[
                Expanded(
                  child: Container(
                    color: PsColors.coreBackgroundColor,
                    child: Stack(children: <Widget>[
                      if (productProvider.productList.data.isNotEmpty &&
                          productProvider.productList.data != null)
                        Container(
                            color: PsColors.coreBackgroundColor,
                            margin: const EdgeInsets.only(
                                left: PsDimens.space8,
                                right: PsDimens.space8,
                                top: PsDimens.space4,
                                bottom: PsDimens.space4),
                            child: RefreshIndicator(
                              child: CustomScrollView(
                                  controller: _scrollController,
                                  scrollDirection: Axis.vertical,
                                  shrinkWrap: true,
                                  slivers: <Widget>[
                                    SliverGrid(
                                      gridDelegate:
                                          const SliverGridDelegateWithMaxCrossAxisExtent(
                                              maxCrossAxisExtent: 220,
                                              childAspectRatio: 0.6),
                                      delegate: SliverChildBuilderDelegate(
                                        (BuildContext context, int index) {
                                          if (productProvider
                                                      .productList.data !=
                                                  null ||
                                              productProvider.productList.data
                                                  .isNotEmpty) {
                                            final int count = productProvider
                                                .productList.data.length;
                                            return ProductVeticalListItem(
                                              coreTagKey: productProvider
                                                      .hashCode
                                                      .toString() +
                                                  productProvider.productList
                                                      .data[index].id,
                                              animationController:
                                                  widget.animationController,
                                              animation: Tween<double>(
                                                      begin: 0.0, end: 1.0)
                                                  .animate(
                                                CurvedAnimation(
                                                  parent: widget
                                                      .animationController,
                                                  curve: Interval(
                                                      (1 / count) * index, 1.0,
                                                      curve:
                                                          Curves.fastOutSlowIn),
                                                ),
                                              ),
                                              product: productProvider
                                                  .productList.data[index],
                                              onTap: () {
                                                final Product product =
                                                    productProvider.productList
                                                        .data[index];
                                                final ProductDetailIntentHolder
                                                    holder =
                                                    ProductDetailIntentHolder(
                                                  product: product,
                                                  heroTagImage: productProvider
                                                          .hashCode
                                                          .toString() +
                                                      product.id +
                                                      PsConst.HERO_TAG__IMAGE,
                                                  heroTagTitle: productProvider
                                                          .hashCode
                                                          .toString() +
                                                      product.id +
                                                      PsConst.HERO_TAG__TITLE,
                                                  heroTagOriginalPrice:
                                                      productProvider.hashCode
                                                              .toString() +
                                                          product.id +
                                                          PsConst
                                                              .HERO_TAG__ORIGINAL_PRICE,
                                                  heroTagUnitPrice: productProvider
                                                          .hashCode
                                                          .toString() +
                                                      product.id +
                                                      PsConst
                                                          .HERO_TAG__UNIT_PRICE,
                                                );

                                                Navigator.pushNamed(context,
                                                    RoutePaths.productDetail,
                                                    arguments: holder);
                                              },
                                            );
                                          } else {
                                            return null;
                                          }
                                        },
                                        childCount: productProvider
                                            .productList.data.length,
                                      ),
                                    ),
                                  ]),
                              onRefresh: () {
                                return productProvider.resetLatestProductList(
                                    productProvider.productParameterHolder);
                              },
                            ))
                      else if (productProvider.productList.status !=
                              PsStatus.PROGRESS_LOADING &&
                          productProvider.productList.status !=
                              PsStatus.BLOCK_LOADING &&
                          productProvider.productList.status !=
                              PsStatus.NOACTION)
                        Align(
                          child: Container(
                            child: Column(
                              mainAxisAlignment: MainAxisAlignment.center,
                              crossAxisAlignment: CrossAxisAlignment.center,
                              mainAxisSize: MainAxisSize.min,
                              children: <Widget>[
                                Image.asset(
                                  'assets/images/baseline_empty_item_grey_24.png',
                                  height: 100,
                                  width: 150,
                                  fit: BoxFit.contain,
                                ),
                                const SizedBox(
                                  height: PsDimens.space32,
                                ),
                                Padding(
                                  padding: const EdgeInsets.only(
                                      left: PsDimens.space20,
                                      right: PsDimens.space20),
                                  child: Text(
                                    Utils.getString(context,
                                        'procuct_list__no_result_data'),
                                    textAlign: TextAlign.center,
                                    style: Theme.of(context)
                                        .textTheme
                                        .headline6
                                        .copyWith(),
                                  ),
                                ),
                                const SizedBox(
                                  height: PsDimens.space20,
                                ),
                              ],
                            ),
                          ),
                        ),
                      PSProgressIndicator(productProvider.productList.status),
                    ]),
                  ),
                ),
              ]);
            });
      },
    );
  }
}

class _HomeCategoryHorizontalListWidget extends StatefulWidget {
  const _HomeCategoryHorizontalListWidget(
      {Key key,
      // @required this.animationController,
      // @required this.animation,
      @required this.shopId,
      @required this.shopName,
      @required this.psValueHolder,
      @required this.userInputItemNameTextEditingController})
      : super(key: key);

  // final AnimationController animationController;
  // final Animation<double> animation;
  final String shopId;
  final String shopName;
  final PsValueHolder psValueHolder;
  final TextEditingController userInputItemNameTextEditingController;

  @override
  __HomeCategoryHorizontalListWidgetState createState() =>
      __HomeCategoryHorizontalListWidgetState();
}

class __HomeCategoryHorizontalListWidgetState
    extends State<_HomeCategoryHorizontalListWidget> {
  @override
  Widget build(BuildContext context) {
    return Consumer<CategoryProvider>(
      builder: (BuildContext context, CategoryProvider categoryProvider,
          Widget child) {
        if (categoryProvider.categoryList.data == null ||
            categoryProvider.categoryList.data.isEmpty) {
          return Container();
        }

        final List<Category> _tmpList =
            List<Category>.from(categoryProvider.categoryList.data);
        int i = 0;

        if (PsConfig.showHome) {
          _tmpList.insert(
              i,
              Category(
                  id: PsConst.mainMenu,
                  name: Utils.getString(context, 'dashboard__main_menu')));
          i++;
        }

        if (PsConfig.showFeaturedItems) {
          _tmpList.insert(
              i,
              Category(
                  id: PsConst.featuredItem,
                  name: Utils.getString(context, 'dashboard__featured_items')));
        }

        if (PsConfig.showSpecialCollections) {
          _tmpList.insert(
              i,
              Category(
                  id: PsConst.specialCollection,
                  name: Utils.getString(
                      context, 'dashboard__special_collection')));
        }
        return HomeTabbarProductListView(
            shopId: widget.shopId,
            shopName: widget.shopName,
            categoryList: _tmpList, //categoryProvider.categoryList.data,
            userInputItemNameTextEditingController:
                widget.userInputItemNameTextEditingController,
            valueHolder: widget.psValueHolder,
            key: Key('${_tmpList.length}'));
      },
    );
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
            top: PsDimens.space20,
            left: PsDimens.space16,
            right: PsDimens.space16,
            bottom: PsDimens.space10),
        child: Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          crossAxisAlignment: CrossAxisAlignment.end,
          children: <Widget>[
            Expanded(
              child: Text(widget.headerName,
                  style: Theme.of(context).textTheme.headline6.copyWith(
                      fontWeight: FontWeight.bold,
                      color: PsColors.textPrimaryDarkColor)),
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
