import 'dart:async';

import 'package:flutter_icons/flutter_icons.dart';
import 'package:fluttermultigrocery/api/common/ps_resource.dart';
import 'package:fluttermultigrocery/api/common/ps_status.dart';
import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/constant/route_paths.dart';
import 'package:fluttermultigrocery/provider/basket/basket_provider.dart';
import 'package:fluttermultigrocery/provider/basket/helper/checkout_calculation_helper.dart';
import 'package:fluttermultigrocery/provider/history/history_provider.dart';
import 'package:fluttermultigrocery/provider/product/favourite_product_provider.dart';
import 'package:fluttermultigrocery/provider/product/product_provider.dart';
import 'package:fluttermultigrocery/provider/product/touch_count_provider.dart';
import 'package:fluttermultigrocery/repository/basket_repository.dart';
import 'package:fluttermultigrocery/repository/history_repsitory.dart';
import 'package:fluttermultigrocery/repository/product_repository.dart';
import 'package:fluttermultigrocery/ui/common/base/ps_widget_with_multi_provider.dart';
import 'package:fluttermultigrocery/ui/common/dialog/confirm_dialog_view.dart';
import 'package:fluttermultigrocery/ui/common/dialog/warning_dialog_view.dart';
import 'package:fluttermultigrocery/ui/common/ps_back_button_with_circle_bg_widget.dart';
import 'package:fluttermultigrocery/ui/common/ps_button_widget.dart';
import 'package:fluttermultigrocery/ui/common/ps_expansion_tile.dart';
import 'package:fluttermultigrocery/ui/common/ps_hero.dart';
import 'package:fluttermultigrocery/ui/common/ps_toast.dart';
import 'package:fluttermultigrocery/ui/common/ps_ui_widget.dart';
import 'package:fluttermultigrocery/ui/common/dialog/error_dialog.dart';
import 'package:fluttermultigrocery/ui/common/smooth_star_rating_widget.dart';
import 'package:fluttermultigrocery/ui/product/detail/views/attributes_item_view.dart';
import 'package:fluttermultigrocery/ui/product/detail/views/color_list_item_view.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/add_on.dart';
import 'package:fluttermultigrocery/viewobject/basket.dart';
import 'package:fluttermultigrocery/viewobject/basket_selected_add_on.dart';
import 'package:fluttermultigrocery/viewobject/basket_selected_attribute.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_value_holder.dart';
import 'package:fluttermultigrocery/viewobject/customized_detail.dart';
import 'package:fluttermultigrocery/viewobject/holder/favourite_parameter_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/attribute_detail_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/touch_count_parameter_holder.dart';
import 'package:fluttermultigrocery/viewobject/product.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:provider/provider.dart';
import 'package:provider/single_child_widget.dart';
import 'package:permission_handler/permission_handler.dart';
import 'package:url_launcher/url_launcher.dart';
import 'views/description_tile_view.dart';
import 'views/detail_info_tile_view.dart';
import 'views/terms_and_policy_tile_view.dart';

class ProductDetailView extends StatefulWidget {
  const ProductDetailView(
      {@required this.product,
      this.heroTagImage,
      this.heroTagTitle,
      this.heroTagOriginalPrice,
      this.heroTagUnitPrice,
      this.intentId,
      this.intentQty,
      this.intentSelectedColorId,
      this.intentSelectedColorValue,
      this.intentBasketPrice,
      this.intentBasketSelectedAttributeList,
      this.intentBasketSelectedAddOnList});

  final String intentId;
  final String intentBasketPrice;
  final List<BasketSelectedAttribute> intentBasketSelectedAttributeList;
  final List<BasketSelectedAddOn> intentBasketSelectedAddOnList;
  final String intentSelectedColorId;
  final String intentSelectedColorValue;
  final Product product;
  final String intentQty;
  final String heroTagImage;
  final String heroTagTitle;
  final String heroTagOriginalPrice;
  final String heroTagUnitPrice;
  @override
  _ProductDetailState createState() => _ProductDetailState();
}

class _ProductDetailState extends State<ProductDetailView>
    with SingleTickerProviderStateMixin {
  ProductRepository productRepo;
  ProductRepository relatedProductRepo;
  HistoryRepository historyRepo;
  HistoryProvider historyProvider;
  TouchCountProvider touchCountProvider;
  BasketProvider basketProvider;
  PsValueHolder psValueHolder;
  AnimationController controller;
  BasketRepository basketRepository;
  List<BasketSelectedAttribute> holderBasketSelectedAttributeList;
  List<BasketSelectedAddOn> holderBasketSelectedAddOnList;

  @override
  void initState() {
    super.initState();
    controller = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 140),
    );
  }

  @override
  void dispose() {
    controller.dispose();
    super.dispose();
  }

  List<Product> basketList = <Product>[];
  bool isReadyToShowAppBarIcons = false;
  double totalPrice;
  double bottomSheetPrice;
  double totalOriginalPrice = 0.0;
  BasketSelectedAttribute basketSelectedAttribute = BasketSelectedAttribute();
  BasketSelectedAddOn basketSelectedAddOn = BasketSelectedAddOn();
  Map<String, CustomizedDetail> selectedcustomizedDetail =
      <String, CustomizedDetail>{};
  Map<AddOn, bool> selectedAddOnList = <AddOn, bool>{};
  double selectedAddOnPrice = 0.0;
  double selectedAttributePrice = 0.0;

  Future<void> updateAttributePrice(
      BasketSelectedAttribute basketSelectedAttribute) async {
    // this.totalOriginalPrice = totalOriginalPrice;
    // Get Total Selected Attribute Price
    selectedAttributePrice =
        basketSelectedAttribute.getTotalSelectedAttributePrice();

    // Update Price
    totalPrice = double.parse(widget.product.unitPrice) +
        selectedAddOnPrice +
        selectedAttributePrice;
    totalOriginalPrice = double.parse(widget.product.originalPrice) +
        selectedAddOnPrice +
        selectedAttributePrice;
    updateBottomPrice();
  }

  dynamic updateBottomPrice() {
    setState(() {
      bottomSheetPrice = totalPrice;
    });
  }

  dynamic addAttributeFromRadioView(
      List<BasketSelectedAttribute> intentbasketSelectedAttributeList,
      CustomizedDetail customizedDetail) {
    setState(() {
      // Update selected attribute
      basketSelectedAttribute.addAttribute(BasketSelectedAttribute(
          id: customizedDetail.id,
          headerId: customizedDetail.headerId,
          name: customizedDetail.name,
          currencySymbol: widget.product.currencySymbol,
          price: customizedDetail.additionalPrice));
      //add radio select data
      holderBasketSelectedAttributeList ??= <BasketSelectedAttribute>[];
      holderBasketSelectedAttributeList.add(BasketSelectedAttribute(
          id: customizedDetail.id,
          headerId: customizedDetail.headerId,
          name: customizedDetail.name,
          currencySymbol: widget.product.currencySymbol,
          price: customizedDetail.additionalPrice));

      updateAttributePrice(basketSelectedAttribute);
    });
  }

  dynamic addAttributeAddOnFromView(
      List<BasketSelectedAddOn> holderBasketSelectedAddOnList,
      AddOn addOn,
      Map<AddOn, bool> addOrSubtractFlagList) {
    setState(() {
      if (addOrSubtractFlagList[addOn]) {
        // add it to use sub or add price
        basketSelectedAddOn.addAddOn(BasketSelectedAddOn(
            id: addOn.id,
            name: addOn.name,
            currencySymbol: widget.product.currencySymbol,
            price: addOn.price));
        //add addOn select data
        holderBasketSelectedAddOnList ??= <BasketSelectedAddOn>[];
        holderBasketSelectedAddOnList.add(BasketSelectedAddOn(
            id: addOn.id,
            name: addOn.name,
            currencySymbol: widget.product.currencySymbol,
            price: addOn.price));
      } else {
        // add it to use sub or add price
        basketSelectedAddOn.subAddOn(BasketSelectedAddOn(
            id: addOn.id,
            name: addOn.name,
            currencySymbol: widget.product.currencySymbol,
            price: addOn.price));
        //remove addOn select data
        holderBasketSelectedAddOnList ??= <BasketSelectedAddOn>[];
        holderBasketSelectedAddOnList.remove(BasketSelectedAddOn(
            id: addOn.id,
            name: addOn.name,
            currencySymbol: widget.product.currencySymbol,
            price: addOn.price));
      }

      updateAddOnPrice(basketSelectedAddOn, addOrSubtractFlagList[addOn]);
    });
  }

  Future<void> updateAddOnPrice(
      BasketSelectedAddOn basketSelectedAddOn, bool addOrSubtractFlag) async {
    // Get Total Selected AddOn Price
    selectedAddOnPrice = basketSelectedAddOn.getTotalSelectedaddOnPrice();

    // Add Price
    totalPrice = double.parse(widget.product.unitPrice) +
        selectedAddOnPrice +
        selectedAttributePrice;
    totalOriginalPrice = double.parse(widget.product.originalPrice) +
        selectedAddOnPrice +
        selectedAttributePrice;

    updateBottomPrice();
  }

  dynamic addIntentAddOnPrice(double price) {
    selectedAddOnPrice += price;
  }

  dynamic addIntentAttributePrice(double price) {
    selectedAttributePrice += price;
  }

  @override
  Widget build(BuildContext context) {
    print('****** Building *********');
    if (!isReadyToShowAppBarIcons) {
      Timer(const Duration(milliseconds: 800), () {
        setState(() {
          isReadyToShowAppBarIcons = true;
        });
      });
    }

    psValueHolder = Provider.of<PsValueHolder>(context);
    productRepo = Provider.of<ProductRepository>(context);
    relatedProductRepo = Provider.of<ProductRepository>(context);
    historyRepo = Provider.of<HistoryRepository>(context);
    basketRepository = Provider.of<BasketRepository>(context);

    if (widget.intentBasketPrice != null &&
        widget.intentBasketPrice != '' &&
        bottomSheetPrice == null) {
      bottomSheetPrice = double.parse(widget.intentBasketPrice);
    }
    if (widget.intentBasketSelectedAttributeList != null &&
        holderBasketSelectedAttributeList == null) {
      holderBasketSelectedAttributeList =
          widget.intentBasketSelectedAttributeList;
    }
    if (widget.intentBasketSelectedAddOnList != null &&
        holderBasketSelectedAddOnList == null) {
      holderBasketSelectedAddOnList = widget.intentBasketSelectedAddOnList;
    }

    return PsWidgetWithMultiProvider(
        child: MultiProvider(
            providers: <SingleChildWidget>[
          ChangeNotifierProvider<ProductDetailProvider>(
            lazy: false,
            create: (BuildContext context) {
              final ProductDetailProvider productDetailProvider =
                  ProductDetailProvider(
                      repo: productRepo, psValueHolder: psValueHolder);

              final String loginUserId = Utils.checkUserLoginId(psValueHolder);
              productDetailProvider.loadProduct(widget.product.id, loginUserId);

              return productDetailProvider;
            },
          ),
          ChangeNotifierProvider<BasketProvider>(
              lazy: false,
              create: (BuildContext context) {
                basketProvider = BasketProvider(repo: basketRepository);
                return basketProvider;
              }),
          ChangeNotifierProvider<HistoryProvider>(
            lazy: false,
            create: (BuildContext context) {
              historyProvider = HistoryProvider(repo: historyRepo);
              return historyProvider;
            },
          ),
          ChangeNotifierProvider<TouchCountProvider>(
            lazy: false,
            create: (BuildContext context) {
              touchCountProvider = TouchCountProvider(
                  repo: productRepo, psValueHolder: psValueHolder);
              final String loginUserId = Utils.checkUserLoginId(psValueHolder);

              final TouchCountParameterHolder touchCountParameterHolder =
                  TouchCountParameterHolder(
                      typeId: widget.product.id,
                      typeName: PsConst.FILTERING_TYPE_NAME_PRODUCT,
                      userId: loginUserId,
                      shopId: widget.product.shop.id);
              touchCountProvider
                  .postTouchCount(touchCountParameterHolder.toMap());
              return touchCountProvider;
            },
          )
        ],
            child: Consumer<ProductDetailProvider>(
              builder: (BuildContext context, ProductDetailProvider provider,
                  Widget child) {
                if (provider.productDetail == null ||
                    provider.productDetail.data == null) {
                  provider.updateProduct(widget.product);
                }

                ///
                /// Add to History
                ///
                historyProvider.addHistoryList(provider.productDetail.data);

                ///
                /// Load Basket List
                ///
                ///
                basketProvider =
                    Provider.of<BasketProvider>(context, listen: false);

                basketProvider.loadBasketList();

                print('detail : latest${widget.product.defaultPhoto.imgId}');
                return Stack(
                  children: <Widget>[
                    CustomScrollView(slivers: <Widget>[
                      SliverAppBar(
                        automaticallyImplyLeading: true,
                        brightness: Utils.getBrightnessForAppBar(context),
                        expandedHeight: PsDimens.space300,
                        iconTheme: Theme.of(context)
                            .iconTheme
                            .copyWith(color: PsColors.mainColorWithWhite),
                        leading: PsBackButtonWithCircleBgWidget(
                          isReadyToShow: isReadyToShowAppBarIcons,
                        ),
                        floating: false,
                        pinned: false,
                        stretch: true,
                        actions: <Widget>[
                          Consumer<BasketProvider>(builder:
                              (BuildContext context,
                                  BasketProvider basketProvider, Widget child) {
                            return Visibility(
                              visible: isReadyToShowAppBarIcons,
                              child: InkWell(
                                  child: Stack(
                                    children: <Widget>[
                                      Container(
                                        width: PsDimens.space40,
                                        height: PsDimens.space40,
                                        margin: const EdgeInsets.only(
                                            top: PsDimens.space8,
                                            left: PsDimens.space8,
                                            right: PsDimens.space8),
                                        child: Align(
                                          alignment: Alignment.center,
                                          child: Icon(
                                            Icons.shopping_basket,
                                            color: PsColors.mainColor,
                                          ),
                                        ),
                                      ),
                                      Positioned(
                                        right: PsDimens.space4,
                                        top: PsDimens.space1,
                                        child: Container(
                                          width: PsDimens.space28,
                                          height: PsDimens.space28,
                                          decoration: BoxDecoration(
                                            shape: BoxShape.circle,
                                            color:
                                                PsColors.black.withAlpha(200),
                                          ),
                                          child: Align(
                                            alignment: Alignment.center,
                                            child: Text(
                                              basketProvider.basketList.data
                                                          .length >
                                                      99
                                                  ? '99+'
                                                  : basketProvider
                                                      .basketList.data.length
                                                      .toString(),
                                              textAlign: TextAlign.left,
                                              style: Theme.of(context)
                                                  .textTheme
                                                  .bodyText1
                                                  .copyWith(
                                                      color: PsColors.white),
                                              maxLines: 1,
                                            ),
                                          ),
                                        ),
                                      ),
                                    ],
                                  ),
                                  onTap: () {
                                    Navigator.pushNamed(
                                      context,
                                      RoutePaths.basketList,
                                    );
                                  }),
                            );
                          })
                        ],
                        backgroundColor: PsColors.mainColorWithBlack,
                        flexibleSpace: FlexibleSpaceBar(
                          background: Container(
                            color: PsColors.backgroundColor,
                            child: PsNetworkImage(
                              photoKey: widget
                                  .heroTagImage, //'latest${widget.product.defaultPhoto.imgId}',
                              defaultPhoto: widget.product.defaultPhoto,
                              width: double.infinity,
                              //height: double.infinity,
                              onTap: () {
                                Navigator.pushNamed(
                                    context, RoutePaths.galleryGrid,
                                    arguments: widget.product);
                              },
                            ),
                          ),
                        ),
                      ),
                      SliverList(
                        delegate: SliverChildListDelegate(<Widget>[
                          Container(
                            color: PsColors.baseColor,
                            child: Column(children: <Widget>[
                              _HeaderBoxWidget(
                                productDetail: provider,
                                product: widget.product,
                                originalPriceFormatString: Utils.getPriceFormat(
                                    provider.productDetail.data.originalPrice),
                                unitPriceFormatString: Utils.getPriceFormat(
                                    provider.productDetail.data.unitPrice),
                                heroTagTitle: widget.heroTagTitle,
                                heroTagOriginalPrice:
                                    widget.heroTagOriginalPrice,
                                heroTagUnitPrice: widget.heroTagUnitPrice,
                                bottomSheetPrice: bottomSheetPrice,
                              ),
                              CustomizeTileView(
                                  productDetail: provider.productDetail.data,
                                  addAttributeFromRadioView:
                                      addAttributeFromRadioView,
                                  intentbasketSelectedAttributeList:
                                      holderBasketSelectedAttributeList ??
                                          <BasketSelectedAttribute>[],
                                  selectedcustomizedDetail:
                                      selectedcustomizedDetail,
                                  addIntentAttributePrice:
                                      addIntentAttributePrice),
                              AddOnTileView(
                                productDetail: provider.productDetail.data,
                                selectedAddOnList: selectedAddOnList,
                                addAttributeAddOnFromView:
                                    addAttributeAddOnFromView,
                                holderBasketSelectedAddOnList:
                                    holderBasketSelectedAddOnList ??
                                        <BasketSelectedAddOn>[],
                                addIntentAddOnPrice: addIntentAddOnPrice,
                              ),
                              DetailInfoTileView(
                                productDetail: provider,
                              ),
                              UserCommentTileView(
                                productDetail: provider,
                              ),
                              TermsAndPolicyTileView(
                                  provider.productDetail.data),
                              // RelatedProductsTileView(
                              //   productDetail: provider,
                              // ),
                              const SizedBox(
                                height: PsDimens.space80,
                              ),
                            ]),
                          )
                        ]),
                      )
                    ]),
                    _AddToBasketAndBuyButtonWidget(
                      controller: controller,
                      productProvider: provider,
                      basketProvider: basketProvider,
                      product: widget.product,
                      psValueHolder: psValueHolder,
                      intentQty: widget.intentQty ?? '',
                      intentSelectedColorId: widget.intentSelectedColorId ?? '',
                      intentSelectedColorValue:
                          widget.intentSelectedColorValue ?? '',
                      intentbasketPrice: widget.intentBasketPrice ?? '',
                      intentbasketSelectedAttributeList:
                          holderBasketSelectedAttributeList ??
                              <BasketSelectedAttribute>[],
                      intentbasketSelectedAddOnList:
                          holderBasketSelectedAddOnList ??
                              <BasketSelectedAddOn>[],
                      selectedAddOnList: selectedAddOnList,
                      selectedcustomizedDetail: selectedcustomizedDetail,
                      bottomSheetPrice: bottomSheetPrice,
                      totalOriginalPrice: totalOriginalPrice,
                      updatePrice: updateAttributePrice,
                      basketSelectedAttribute: basketSelectedAttribute,
                      holderBasketSelectedAddOnList:
                          holderBasketSelectedAddOnList ??
                              <BasketSelectedAddOn>[],
                      basketSelectedAddOn: basketSelectedAddOn,
                    )
                  ],
                );
              },
            )));
  }
}

class CustomizeTileView extends StatefulWidget {
  const CustomizeTileView(
      {Key key,
      @required this.productDetail,
      @required this.addAttributeFromRadioView,
      @required this.intentbasketSelectedAttributeList,
      @required this.selectedcustomizedDetail,
      @required this.addIntentAttributePrice})
      : super(key: key);

  final Product productDetail;
  final Function addAttributeFromRadioView;
  final List<BasketSelectedAttribute> intentbasketSelectedAttributeList;
  final Map<String, CustomizedDetail> selectedcustomizedDetail;
  final Function addIntentAttributePrice;

  @override
  _CustomizeTileViewState createState() => _CustomizeTileViewState();
}

class _CustomizeTileViewState extends State<CustomizeTileView> {
  dynamic setSelectedData(CustomizedDetail customizedDetail, String headerId) {
    setState(() {
      widget.selectedcustomizedDetail[headerId] = customizedDetail;
      widget.addAttributeFromRadioView(
          widget.intentbasketSelectedAttributeList, customizedDetail);
    });
  }

  List<Widget> createRadioListWidget(
      List<CustomizedDetail> customizedDetailMapList, String headerId) {
    final List<Widget> widgets = <Widget>[];
    for (CustomizedDetail customizedDetail in customizedDetailMapList) {
      widgets.add(
        InkWell(
          onTap: () {
            setSelectedData(customizedDetail, headerId);
          },
          child: Container(
            width: MediaQuery.of(context).size.width,
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: <Widget>[
                Expanded(
                  child: Row(
                    children: <Widget>[
                      Radio<CustomizedDetail>(
                        value: customizedDetail,
                        groupValue: widget.selectedcustomizedDetail[headerId],
                        onChanged: (dynamic customizedDetail) {
                          setSelectedData(customizedDetail, headerId);
                        },
                        materialTapTargetSize: MaterialTapTargetSize.shrinkWrap,
                        activeColor: PsColors.mainColor,
                      ),
                      Expanded(
                        child: Text(
                          customizedDetail.name,
                          style:
                              Theme.of(context).textTheme.bodyText2.copyWith(),
                          maxLines: 1,
                          overflow: TextOverflow.ellipsis,
                        ),
                      ),
                    ],
                  ),
                ),
                if (customizedDetail.additionalPrice == null ||
                    customizedDetail.additionalPrice == '')
                  Container()
                else
                  Text(
                      '+ ${widget.productDetail.currencySymbol} ' +
                          getPriceFormat('${customizedDetail.additionalPrice}'),
                      style: Theme.of(context).textTheme.bodyText2.copyWith())
              ],
            ),
          ),
        ),
      );
    }
    return widgets;
  }

  @override
  Widget build(BuildContext context) {
    if (widget.intentbasketSelectedAttributeList != null &&
        widget.intentbasketSelectedAttributeList.isNotEmpty &&
        widget.selectedcustomizedDetail.isEmpty) {
      for (BasketSelectedAttribute basketSelectedAttribute
          in widget.intentbasketSelectedAttributeList) {
        widget.selectedcustomizedDetail[basketSelectedAttribute.headerId] =
            CustomizedDetail(
                id: basketSelectedAttribute.id,
                headerId: basketSelectedAttribute.headerId,
                name: basketSelectedAttribute.name,
                additionalPrice: basketSelectedAttribute.price);
        if (basketSelectedAttribute.price != '') {
          widget.addIntentAttributePrice(
              double.parse(basketSelectedAttribute.price));
        }
      }
    }
    final Widget _expansionTileTitleWidget = Text(
        Utils.getString(context, 'customize_tile__title'),
        style: Theme.of(context).textTheme.subtitle1);
    if (widget.productDetail.customizedHeaderList.isNotEmpty &&
        widget.productDetail.customizedHeaderList[0].id != '') {
      return Container(
        margin: const EdgeInsets.only(
            left: PsDimens.space12,
            right: PsDimens.space12,
            bottom: PsDimens.space12),
        decoration: BoxDecoration(
          color: PsColors.backgroundColor,
          borderRadius:
              const BorderRadius.all(Radius.circular(PsDimens.space8)),
        ),
        child: PsExpansionTile(
            initiallyExpanded: true,
            title: _expansionTileTitleWidget,
            children: <Widget>[
              MediaQuery.removePadding(
                context: context,
                removeTop: true,
                child: ListView.builder(
                  physics: const NeverScrollableScrollPhysics(),
                  shrinkWrap: true,
                  scrollDirection: Axis.vertical,
                  itemCount: widget.productDetail.customizedHeaderList.length,
                  itemBuilder: (BuildContext context, int index) {
                    return Padding(
                      padding: const EdgeInsets.only(
                          bottom: PsDimens.space16,
                          left: PsDimens.space32,
                          right: PsDimens.space16),
                      child: Column(
                        mainAxisSize: MainAxisSize.max,
                        crossAxisAlignment: CrossAxisAlignment.start,
                        mainAxisAlignment: MainAxisAlignment.start,
                        children: <Widget>[
                          Row(
                            mainAxisAlignment: MainAxisAlignment.spaceBetween,
                            children: <Widget>[
                              Text(
                                  widget.productDetail
                                      .customizedHeaderList[index].name,
                                  style: Theme.of(context)
                                      .textTheme
                                      .bodyText2
                                      .copyWith(fontWeight: FontWeight.bold)),
                              Padding(
                                padding: const EdgeInsets.only(
                                    right: PsDimens.space16),
                                child: Text(
                                  Utils.getString(
                                      context, 'customize_tile__1_require'),
                                  style: Theme.of(context)
                                      .textTheme
                                      .bodyText2
                                      .copyWith(color: PsColors.mainColor),
                                ),
                              )
                            ],
                          ),
                          Padding(
                            padding:
                                const EdgeInsets.only(top: PsDimens.space8),
                            child: Text(
                                Utils.getString(
                                    context, 'customize_tile__select_1'),
                                textAlign: TextAlign.start,
                                style: Theme.of(context)
                                    .textTheme
                                    .bodyText2
                                    .copyWith()),
                          ),
                          if (widget.productDetail.customizedHeaderList[index]
                                  .customizedDetail[0].id !=
                              '')
                            Column(
                                mainAxisSize: MainAxisSize.max,
                                children: createRadioListWidget(
                                    widget
                                        .productDetail
                                        .customizedHeaderList[index]
                                        .customizedDetail,
                                    widget.productDetail
                                        .customizedHeaderList[index].id)),
                        ],
                      ),
                    );
                  },
                ),
              )
            ]),
      );
    } else {
      return const Card();
    }
  }
}

class AddOnTileView extends StatefulWidget {
  const AddOnTileView(
      {Key key,
      @required this.productDetail,
      @required this.selectedAddOnList,
      @required this.addAttributeAddOnFromView,
      @required this.holderBasketSelectedAddOnList,
      @required this.addIntentAddOnPrice})
      : super(key: key);

  final Product productDetail;
  final Map<AddOn, bool> selectedAddOnList;
  final Function addAttributeAddOnFromView;
  final List<BasketSelectedAddOn> holderBasketSelectedAddOnList;
  final Function addIntentAddOnPrice;

  @override
  _AddOnTileViewState createState() => _AddOnTileViewState();
}

class _AddOnTileViewState extends State<AddOnTileView> {
  @override
  Widget build(BuildContext context) {
    if (widget.holderBasketSelectedAddOnList != null &&
        widget.holderBasketSelectedAddOnList.isNotEmpty &&
        widget.selectedAddOnList.isEmpty) {
      for (BasketSelectedAddOn basketSelectedAddOn
          in widget.holderBasketSelectedAddOnList) {
        widget.selectedAddOnList[AddOn(
            id: basketSelectedAddOn.id,
            name: basketSelectedAddOn.name,
            price: basketSelectedAddOn.price)] = true;
        if (basketSelectedAddOn.price != '') {
          widget.addIntentAddOnPrice(double.parse(basketSelectedAddOn.price));
        }
      }
    }
    final Widget _expansionTileTitleWidget = Text(
        Utils.getString(context, 'add_on_tile__title'),
        style: Theme.of(context).textTheme.subtitle1);
    if (widget.productDetail.addOnList.isNotEmpty &&
        widget.productDetail.addOnList[0].id != '') {
      return Container(
        margin: const EdgeInsets.only(
            left: PsDimens.space12,
            right: PsDimens.space12,
            bottom: PsDimens.space12),
        decoration: BoxDecoration(
          color: PsColors.backgroundColor,
          borderRadius:
              const BorderRadius.all(Radius.circular(PsDimens.space8)),
        ),
        child: PsExpansionTile(
            initiallyExpanded: true,
            title: _expansionTileTitleWidget,
            children: <Widget>[
              MediaQuery.removePadding(
                context: context,
                removeTop: true,
                child: Padding(
                  padding: const EdgeInsets.only(
                      bottom: PsDimens.space16, right: PsDimens.space16),
                  child: ListView.builder(
                      physics: const NeverScrollableScrollPhysics(),
                      scrollDirection: Axis.vertical,
                      shrinkWrap: true,
                      itemCount: widget.productDetail.addOnList.length,
                      itemBuilder: (BuildContext context, int index) {
                        return InkWell(
                          onTap: () {
                            setState(() {});
                            if (widget.selectedAddOnList[
                                    widget.productDetail.addOnList[index]] ==
                                true)
                              widget.selectedAddOnList[widget
                                  .productDetail.addOnList[index]] = false;
                            else
                              widget.selectedAddOnList[
                                  widget.productDetail.addOnList[index]] = true;
                            Utils.psPrint('Clicked Add on');
                            widget.addAttributeAddOnFromView(
                                widget.holderBasketSelectedAddOnList,
                                widget.productDetail.addOnList[index],
                                widget.selectedAddOnList);
                          },
                          child: Padding(
                            padding: const EdgeInsets.only(
                                top: PsDimens.space8, left: PsDimens.space32),
                            child: Row(
                                mainAxisAlignment:
                                    MainAxisAlignment.spaceBetween,
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: <Widget>[
                                  Expanded(
                                    child: Row(
                                      children: <Widget>[
                                        Stack(
                                          alignment: Alignment.center,
                                          children: <Widget>[
                                            PsNetworkImage(
                                              photoKey: '',
                                              defaultPhoto: widget
                                                  .productDetail
                                                  .addOnList[index]
                                                  .defaultPhoto,
                                              width: PsDimens.space60,
                                              height: PsDimens.space60,
                                              onTap: () {
                                                if (widget.selectedAddOnList[
                                                        widget.productDetail
                                                                .addOnList[
                                                            index]] ==
                                                    true)
                                                  widget.selectedAddOnList[
                                                      widget.productDetail
                                                              .addOnList[
                                                          index]] = false;
                                                else
                                                  widget.selectedAddOnList[
                                                      widget.productDetail
                                                              .addOnList[
                                                          index]] = true;
                                                Utils.psPrint('Clicked Add on');
                                                widget.addAttributeAddOnFromView(
                                                    widget
                                                        .holderBasketSelectedAddOnList,
                                                    widget.productDetail
                                                        .addOnList[index],
                                                    widget.selectedAddOnList);
                                              },
                                            ),
                                            if (widget.selectedAddOnList
                                                    .containsKey(widget
                                                        .productDetail
                                                        .addOnList[index]) &&
                                                widget.selectedAddOnList[widget
                                                    .productDetail
                                                    .addOnList[index]])
                                              Container(
                                                width: PsDimens.space60,
                                                height: PsDimens.space60,
                                                child: CircleAvatar(
                                                  child: Icon(
                                                      Icons.check_circle,
                                                      size: PsDimens.space44,
                                                      color:
                                                          PsColors.mainColor),
                                                  backgroundColor:
                                                      PsColors.transparent,
                                                ),
                                              )
                                            else
                                              Container()
                                          ],
                                        ),
                                        Expanded(
                                          child: Padding(
                                            padding: const EdgeInsets.all(8.0),
                                            child: Column(
                                              crossAxisAlignment:
                                                  CrossAxisAlignment.start,
                                              children: <Widget>[
                                                Text(
                                                  widget.productDetail
                                                      .addOnList[index].name,
                                                  style: Theme.of(context)
                                                      .textTheme
                                                      .bodyText2
                                                      .copyWith(
                                                          color: PsColors
                                                              .textPrimaryDarkColor),
                                                  maxLines: 1,
                                                  overflow:
                                                      TextOverflow.ellipsis,
                                                ),
                                                Padding(
                                                  padding:
                                                      const EdgeInsets.only(
                                                          top: 4.0),
                                                  child: Text(
                                                    widget
                                                        .productDetail
                                                        .addOnList[index]
                                                        .description,
                                                    style: Theme.of(context)
                                                        .textTheme
                                                        .bodyText2
                                                        .copyWith(
                                                            color: PsColors
                                                                .textPrimaryLightColor),
                                                    maxLines: 2,
                                                    overflow:
                                                        TextOverflow.ellipsis,
                                                  ),
                                                )
                                              ],
                                            ),
                                          ),
                                        ),
                                      ],
                                    ),
                                  ),
                                  if (widget.productDetail.addOnList[index]
                                              .price ==
                                          null ||
                                      widget.productDetail.addOnList[index]
                                              .price ==
                                          '')
                                    Container()
                                  else
                                    Padding(
                                      padding: const EdgeInsets.only(top: 12.0),
                                      child: Text(
                                          '+ ${widget.productDetail.currencySymbol} ' +
                                              getPriceFormat(
                                                  '${widget.productDetail.addOnList[index].price}')),
                                    ),
                                ]),
                          ),
                        );
                      }),
                ),
              ),
              const SizedBox(height: PsDimens.space16),
            ]),
      );
    } else {
      return const Card();
    }
  }
}

class UserCommentTileView extends StatelessWidget {
  const UserCommentTileView({
    Key key,
    @required this.productDetail,
  }) : super(key: key);

  final ProductDetailProvider productDetail;
  @override
  Widget build(BuildContext context) {
    final Widget _expansionTileTitleWidget = Text(
        Utils.getString(context, 'user_comment_tile__user_comment'),
        style: Theme.of(context).textTheme.subtitle1);
    if (productDetail != null) {
      return Container(
        margin: const EdgeInsets.only(
            left: PsDimens.space12,
            right: PsDimens.space12,
            bottom: PsDimens.space12),
        decoration: BoxDecoration(
          color: PsColors.backgroundColor,
          borderRadius:
              const BorderRadius.all(Radius.circular(PsDimens.space8)),
        ),
        child: PsExpansionTile(
          initiallyExpanded: true,
          title: _expansionTileTitleWidget,
          children: <Widget>[
            Column(
              children: <Widget>[
                InkWell(
                  onTap: () async {
                    final dynamic returnData = await Navigator.pushNamed(
                        context, RoutePaths.commentList,
                        arguments: productDetail.productDetail.data);

                    if (returnData != null && returnData) {
                      productDetail.loadProduct(
                          productDetail.productDetail.data.id,
                          productDetail.psValueHolder.loginUserId);
                    }
                  },
                  child: Padding(
                    padding: const EdgeInsets.all(PsDimens.space16),
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: <Widget>[
                        Text(
                          Utils.getString(
                              context, 'user_comment_tile__view_all_comment'),
                          style: Theme.of(context)
                              .textTheme
                              .bodyText2
                              .copyWith(color: PsColors.mainColor),
                        ),
                        GestureDetector(
                            onTap: () async {
                              final dynamic returnData =
                                  await Navigator.pushNamed(
                                      context, RoutePaths.commentList,
                                      arguments:
                                          productDetail.productDetail.data);

                              if (returnData) {
                                productDetail.loadProduct(
                                    productDetail.productDetail.data.id,
                                    productDetail.psValueHolder.loginUserId);
                              }
                            },
                            child: const Icon(
                              Icons.arrow_forward_ios,
                              size: PsDimens.space16,
                            )),
                      ],
                    ),
                  ),
                ),
                InkWell(
                    onTap: () async {
                      final dynamic returnData = await Navigator.pushNamed(
                          context, RoutePaths.commentList,
                          arguments: productDetail.productDetail.data);

                      if (returnData != null && returnData) {
                        productDetail.loadProduct(
                            productDetail.productDetail.data.id,
                            productDetail.psValueHolder.loginUserId);
                      }
                    },
                    child: Padding(
                      padding: const EdgeInsets.all(PsDimens.space16),
                      child: Row(
                        children: <Widget>[
                          Container(
                            child: Text(
                              Utils.getString(
                                  context, 'user_comment_tile__write_comment'),
                              style: Theme.of(context)
                                  .textTheme
                                  .bodyText2
                                  .copyWith(
                                    color: PsColors.mainColor,
                                  ),
                              textAlign: TextAlign.left,
                            ),
                          ),
                        ],
                      ),
                    ))
              ],
            ),
          ],
        ),
      );
    } else {
      return const Card();
    }
  }
}

class _HeaderBoxWidget extends StatefulWidget {
  const _HeaderBoxWidget(
      {Key key,
      @required this.productDetail,
      @required this.product,
      @required this.originalPriceFormatString,
      @required this.unitPriceFormatString,
      @required this.heroTagTitle,
      @required this.heroTagOriginalPrice,
      @required this.heroTagUnitPrice,
      @required this.bottomSheetPrice})
      : super(key: key);

  final ProductDetailProvider productDetail;
  final Product product;
  final String originalPriceFormatString;
  final String unitPriceFormatString;
  final String heroTagTitle;
  final String heroTagOriginalPrice;
  final String heroTagUnitPrice;
  final double bottomSheetPrice;

  @override
  __HeaderBoxWidgetState createState() => __HeaderBoxWidgetState();
}

class __HeaderBoxWidgetState extends State<_HeaderBoxWidget> {
  @override
  Widget build(BuildContext context) {
    if (widget.product != null &&
        widget.productDetail != null &&
        widget.productDetail.productDetail != null &&
        widget.productDetail.productDetail.data != null) {
      return Container(
        margin: const EdgeInsets.all(PsDimens.space12),
        decoration: BoxDecoration(
          color: PsColors.backgroundColor,
          borderRadius:
              const BorderRadius.all(Radius.circular(PsDimens.space8)),
        ),
        child: Column(
          children: <Widget>[
            Padding(
                padding: const EdgeInsets.all(PsDimens.space16),
                child: Column(
                  children: <Widget>[
                    _FavouriteWidget(
                        productDetail: widget.productDetail,
                        product: widget.product,
                        heroTagTitle: widget.heroTagTitle),
                    const SizedBox(
                      height: PsDimens.space12,
                    ),
                    _HeaderPriceWidget(
                      product: widget.productDetail.productDetail.data,
                      originalPriceFormatString:
                          widget.originalPriceFormatString,
                      unitPriceFormatString: widget.unitPriceFormatString,
                      heroTagOriginalPrice: widget.heroTagOriginalPrice,
                      heroTagUnitPrice: widget.heroTagUnitPrice,
                      price: widget.bottomSheetPrice ??
                          double.parse(widget.product.unitPrice),
                    ),
                    const SizedBox(
                      height: PsDimens.space12,
                    ),
                    Divider(
                      height: PsDimens.space1,
                      color: PsColors.mainColor,
                    ),
                    Padding(
                      padding: const EdgeInsets.only(
                          top: PsDimens.space16, bottom: PsDimens.space4),
                      child: _HeaderRatingWidget(
                        productDetail: widget.productDetail,
                      ),
                    ),
                  ],
                )),
            Container(
              margin: const EdgeInsets.only(
                  left: PsDimens.space20,
                  right: PsDimens.space20,
                  bottom: PsDimens.space8),
              child: Card(
                elevation: 0.0,
                shape: const BeveledRectangleBorder(
                  borderRadius:
                      BorderRadius.all(Radius.circular(PsDimens.space8)),
                ),
                color: PsColors.baseLightColor,
                child: Padding(
                  padding: const EdgeInsets.all(12.0),
                  child: Text(
                    widget.productDetail.productDetail.data
                            .highlightInformation ??
                        '',
                    style: Theme.of(context).textTheme.bodyText2.copyWith(
                        letterSpacing: 0.8, fontSize: 16, height: 1.3),
                  ),
                ),
              ),
            ),
            DescriptionTileView(
              productDetail: widget.productDetail.productDetail.data,
            ),
            // const Divider(
            //   height: PsDimens.space1,
            // ),
            // _HeaderButtonWidget(
            //   productDetail: widget.productDetail.productDetail.data,
            // ),
          ],
        ),
      );
    } else {
      return Container();
    }
  }
}

class _FavouriteWidget extends StatefulWidget {
  const _FavouriteWidget(
      {Key key,
      @required this.productDetail,
      @required this.product,
      @required this.heroTagTitle})
      : super(key: key);

  final ProductDetailProvider productDetail;
  final Product product;
  final String heroTagTitle;

  @override
  __FavouriteWidgetState createState() => __FavouriteWidgetState();
}

class __FavouriteWidgetState extends State<_FavouriteWidget> {
  Widget icon;
  ProductRepository favouriteRepo;
  PsValueHolder psValueHolder;

  @override
  Widget build(BuildContext context) {
    favouriteRepo = Provider.of<ProductRepository>(context);
    psValueHolder = Provider.of<PsValueHolder>(context);

    if (widget.product != null &&
        widget.productDetail != null &&
        widget.productDetail.productDetail != null &&
        widget.productDetail.productDetail.data != null &&
        widget.productDetail.productDetail.data.isFavourited != null) {
      return ChangeNotifierProvider<FavouriteProductProvider>(
          lazy: false,
          create: (BuildContext context) {
            final FavouriteProductProvider provider = FavouriteProductProvider(
                repo: favouriteRepo, psValueHolder: psValueHolder);

            return provider;
          },
          child: Consumer<FavouriteProductProvider>(builder:
              (BuildContext context, FavouriteProductProvider provider,
                  Widget child) {
            return Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: <Widget>[
                  Expanded(
                    child: PsHero(
                        tag: widget.heroTagTitle,
                        child: Text(
                          widget.productDetail.productDetail.data.name ?? '',
                          style: Theme.of(context).textTheme.headline5,
                        )),
                  ),
                  GestureDetector(
                      onTap: () async {
                        if (await Utils.checkInternetConnectivity()) {
                          Utils.navigateOnUserVerificationView(context,
                              () async {
                            if (widget.productDetail.productDetail.data
                                    .isFavourited ==
                                '0') {
                              setState(() {
                                widget.productDetail.productDetail.data
                                    .isFavourited = '1';
                              });
                            } else {
                              setState(() {
                                widget.productDetail.productDetail.data
                                    .isFavourited = '0';
                              });
                            }

                            final FavouriteParameterHolder
                                favouriteParameterHolder =
                                FavouriteParameterHolder(
                                    userId: provider.psValueHolder.loginUserId,
                                    productId: widget.product.id,
                                    shopId: widget.product.shop.id);

                            final PsResource<Product> _apiStatus =
                                await provider.postFavourite(
                                    favouriteParameterHolder.toMap());

                            if (_apiStatus.data != null) {
                              if (_apiStatus.status == PsStatus.SUCCESS) {
                                await widget.productDetail.loadProductForFav(
                                    widget.product.id,
                                    provider.psValueHolder.loginUserId);
                              }
                              if (widget.productDetail != null &&
                                  widget.productDetail.productDetail != null &&
                                  widget.productDetail.productDetail.data !=
                                      null) {
                                if (widget.productDetail.productDetail.data
                                        .isFavourited ==
                                    PsConst.ONE) {
                                  icon = Container(
                                    padding: const EdgeInsets.only(
                                        top: PsDimens.space8,
                                        left: PsDimens.space8,
                                        right: PsDimens.space8,
                                        bottom: PsDimens.space6),
                                    decoration: BoxDecoration(
                                        border: Border.all(
                                            color: PsColors.mainColor),
                                        shape: BoxShape.circle),
                                    child: Icon(Icons.favorite,
                                        color: PsColors.mainColor),
                                  );
                                } else {
                                  icon = Container(
                                    padding: const EdgeInsets.only(
                                        top: PsDimens.space8,
                                        left: PsDimens.space8,
                                        right: PsDimens.space8,
                                        bottom: PsDimens.space6),
                                    decoration: BoxDecoration(
                                        border: Border.all(
                                            color: PsColors.mainColor),
                                        shape: BoxShape.circle),
                                    child: Icon(Icons.favorite_border,
                                        color: PsColors.mainColor),
                                  );
                                }
                              }
                            } else {
                              print('There is no comment');
                            }
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
                      child: (widget.productDetail != null &&
                              widget.productDetail.productDetail != null &&
                              widget.productDetail.productDetail.data != null)
                          ? widget.productDetail.productDetail.data
                                      .isFavourited ==
                                  PsConst.ZERO
                              ? icon = Container(
                                  padding: const EdgeInsets.only(
                                      top: PsDimens.space8,
                                      left: PsDimens.space8,
                                      right: PsDimens.space8,
                                      bottom: PsDimens.space6),
                                  decoration: BoxDecoration(
                                      border:
                                          Border.all(color: PsColors.mainColor),
                                      shape: BoxShape.circle),
                                  child: Icon(Icons.favorite_border,
                                      color: PsColors.mainColor),
                                )
                              : icon = Container(
                                  padding: const EdgeInsets.only(
                                      top: PsDimens.space8,
                                      left: PsDimens.space8,
                                      right: PsDimens.space8,
                                      bottom: PsDimens.space6),
                                  decoration: BoxDecoration(
                                      border:
                                          Border.all(color: PsColors.mainColor),
                                      shape: BoxShape.circle),
                                  child: Icon(Icons.favorite,
                                      color: PsColors.mainColor),
                                )
                          : Container())
                ]);
          }));
    } else {
      return Container();
    }
  }
}

class _HeaderRatingWidget extends StatefulWidget {
  const _HeaderRatingWidget({
    Key key,
    @required this.productDetail,
  }) : super(key: key);

  final ProductDetailProvider productDetail;

  @override
  __HeaderRatingWidgetState createState() => __HeaderRatingWidgetState();
}

class __HeaderRatingWidgetState extends State<_HeaderRatingWidget> {
  @override
  Widget build(BuildContext context) {
    dynamic result;
    if (widget.productDetail != null &&
        widget.productDetail.productDetail != null &&
        widget.productDetail.productDetail.data != null &&
        widget.productDetail.productDetail.data.ratingDetail != null) {
      return Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: <Widget>[
          InkWell(
            onTap: () async {
              result = await Navigator.pushNamed(context, RoutePaths.ratingList,
                  arguments: widget.productDetail.productDetail.data.id);

              if (result != null && result) {
                setState(() {
                  widget.productDetail.loadProduct(
                      widget.productDetail.productDetail.data.id,
                      widget.productDetail.psValueHolder.loginUserId);
                });
              }
            },
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: <Widget>[
                InkWell(
                  onTap: () async {
                    result = await Navigator.pushNamed(
                        context, RoutePaths.ratingList,
                        arguments: widget.productDetail.productDetail.data.id);

                    if (result != null && result) {
                      widget.productDetail.loadProduct(
                          widget.productDetail.productDetail.data.id,
                          widget.productDetail.psValueHolder.loginUserId);
                    }
                  },
                  child: SmoothStarRating(
                      key: Key(widget.productDetail.productDetail.data
                          .ratingDetail.totalRatingValue),
                      rating: double.parse(widget.productDetail.productDetail
                          .data.ratingDetail.totalRatingValue),
                      allowHalfRating: false,
                      isReadOnly: true,
                      starCount: 5,
                      size: PsDimens.space16,
                      color: PsColors.ratingColor,
                      borderColor: PsColors.grey.withAlpha(100),
                      onRated: (double v) async {},
                      spacing: 0.0),
                ),
                const SizedBox(
                  height: PsDimens.space10,
                ),
                GestureDetector(
                    onTap: () async {
                      result = await Navigator.pushNamed(
                          context, RoutePaths.ratingList,
                          arguments:
                              widget.productDetail.productDetail.data.id);

                      if (result != null && result) {
                        widget.productDetail.loadProduct(
                            widget.productDetail.productDetail.data.id,
                            widget.productDetail.psValueHolder.loginUserId);
                      }
                    },
                    child: (widget.productDetail.productDetail.data
                                .overallRating !=
                            '0')
                        ? Row(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: <Widget>[
                              Text(
                                widget.productDetail.productDetail.data
                                        .ratingDetail.totalRatingValue ??
                                    '',
                                textAlign: TextAlign.left,
                                style: Theme.of(context)
                                    .textTheme
                                    .bodyText2
                                    .copyWith(),
                              ),
                              const SizedBox(
                                width: PsDimens.space4,
                              ),
                              Text(
                                '${Utils.getString(context, 'product_detail__out_of_five_stars')}(' +
                                    widget.productDetail.productDetail.data
                                        .ratingDetail.totalRatingCount +
                                    ' ${Utils.getString(context, 'product_detail__reviews')})',
                                overflow: TextOverflow.ellipsis,
                                style: Theme.of(context)
                                    .textTheme
                                    .bodyText2
                                    .copyWith(),
                              ),
                            ],
                          )
                        : Text(Utils.getString(
                            context, 'product_detail__no_rating'))),
                const SizedBox(
                  height: PsDimens.space10,
                ),
                if (widget.productDetail.productDetail.data.isAvailable == '1')
                  Text(
                    Utils.getString(context, 'product_detail__in_stock'),
                    style: Theme.of(context)
                        .textTheme
                        .bodyText2
                        .copyWith(color: PsColors.mainDarkColor),
                  )
                else
                  Container(),
              ],
            ),
          ),
          Expanded(
            child: Column(
              mainAxisAlignment: MainAxisAlignment.end,
              mainAxisSize: MainAxisSize.max,
              crossAxisAlignment: CrossAxisAlignment.end,
              children: <Widget>[
                if (widget.productDetail.productDetail.data.isFeatured == '0')
                  Container()
                else
                  Row(
                    mainAxisAlignment: MainAxisAlignment.end,
                    children: <Widget>[
                      Image.asset(
                        'assets/images/baseline_feature_circle_24.png',
                        width: PsDimens.space28,
                        height: PsDimens.space28,
                      ),
                      const SizedBox(
                        width: PsDimens.space8,
                      ),
                      Text(
                        Utils.getString(
                            context, 'product_detail__main_products'),
                        overflow: TextOverflow.ellipsis,
                        style: Theme.of(context).textTheme.caption.copyWith(
                              color: PsColors.mainColor,
                            ),
                      ),
                    ],
                  ),
                const SizedBox(
                  height: PsDimens.space8,
                ),
                Text(
                  widget.productDetail.productDetail.data.code ?? '',
                  style: Theme.of(context)
                      .textTheme
                      .bodyText1
                      .copyWith(color: PsColors.mainDarkColor),
                ),
              ],
            ),
          ),
        ],
      );
    } else {
      return Container();
    }
  }
}

class _HeaderPriceWidget extends StatefulWidget {
  const _HeaderPriceWidget(
      {Key key,
      @required this.product,
      @required this.originalPriceFormatString,
      @required this.unitPriceFormatString,
      @required this.heroTagOriginalPrice,
      @required this.heroTagUnitPrice,
      @required this.price})
      : super(key: key);

  final Product product;
  final String originalPriceFormatString;
  final String unitPriceFormatString;
  final String heroTagOriginalPrice;
  final String heroTagUnitPrice;
  final double price;
  @override
  __HeaderPriceWidgetState createState() => __HeaderPriceWidgetState();
}

class __HeaderPriceWidgetState extends State<_HeaderPriceWidget> {
  Future<bool> requestWritePermission() async {
    // final Map<PermissionGroup, PermissionStatus> permissionss =
    //     await PermissionHandler()
    //         .requestPermissions(<PermissionGroup>[PermissionGroup.storage]);
    // if (permissionss != null &&
    //     permissionss.isNotEmpty &&
    //     permissionss[PermissionGroup.storage] == PermissionStatus.granted) {
    //   return true;
    // } else {
    //   return false;
    // }

    final Permission _photos = Permission.photos;
    final PermissionStatus permissionss = await _photos.request();

    if (permissionss != null && permissionss == PermissionStatus.granted) {
      return true;
    } else {
      return false;
    }
  }

  @override
  Widget build(BuildContext context) {
    print('******* ${widget.unitPriceFormatString}');
    if (widget.product != null && widget.product.unitPrice != null) {
      return Row(
        mainAxisAlignment: MainAxisAlignment.start,
        mainAxisSize: MainAxisSize.max,
        children: <Widget>[
          Container(
            color: PsColors.transparent,
            child: Column(
              mainAxisSize: MainAxisSize.max,
              children: <Widget>[
                if (widget.product.isDiscount == PsConst.ONE)
                  PsHero(
                      tag: widget.heroTagOriginalPrice,
                      flightShuttleBuilder: Utils.flightShuttleBuilder,
                      child: Material(
                          color: PsColors.transparent,
                          child: Text(
                            '${widget.product.currencySymbol}${widget.originalPriceFormatString}',
                            style: Theme.of(context)
                                .textTheme
                                .bodyText2
                                .copyWith(
                                    decoration: TextDecoration.lineThrough),
                          )))
                else
                  Container(),
                const SizedBox(
                  height: PsDimens.space4,
                ),
                PsHero(
                  tag: widget.heroTagUnitPrice,
                  flightShuttleBuilder: Utils.flightShuttleBuilder,
                  child: Material(
                      color: PsColors.transparent,
                      child: Text(
                        widget.price != null
                            ? '${widget.product.currencySymbol} ${Utils.getPriceFormat(widget.price.toString())}'
                            : '${widget.product.currencySymbol} ${Utils.getPriceFormat(widget.product.unitPrice)}',
                        // '${widget.product.currencySymbol}${widget.unitPriceFormatString}',
                        //overflow: TextOverflow.ellipsis,
                        style: Theme.of(context)
                            .textTheme
                            .subtitle1
                            .copyWith(color: PsColors.mainColor),
                      )),
                ),
              ],
            ),
          ),
          const SizedBox(
            width: PsDimens.space16,
          ),
          if (widget.product.isDiscount == PsConst.ONE)
            Card(
              elevation: 0,
              color: PsColors.discountColor,
              shape: const BeveledRectangleBorder(
                  borderRadius: BorderRadius.only(
                      topLeft: Radius.circular(PsDimens.space8),
                      bottomLeft: Radius.circular(PsDimens.space8))),
              child: Container(
                width: 80,
                height: 30,
                padding: const EdgeInsets.only(
                    left: PsDimens.space4, right: PsDimens.space4),
                child: Align(
                  child: Text(
                    '${widget.product.discountPercent}% ' +
                        Utils.getString(
                            context, 'product_detail__discount_off'),
                    style: Theme.of(context)
                        .textTheme
                        .subtitle1
                        .copyWith(color: PsColors.white),
                  ),
                ),
              ),
            )
          else
            Container(),
          const SizedBox(
            width: PsDimens.space10,
          ),
        ],
      );
    } else {
      return Container();
    }
  }
}

class _AddToBasketAndBuyButtonWidget extends StatefulWidget {
  const _AddToBasketAndBuyButtonWidget({
    Key key,
    @required this.controller,
    @required this.productProvider,
    @required this.basketProvider,
    @required this.product,
    @required this.psValueHolder,
    @required this.intentQty,
    @required this.intentSelectedColorId,
    @required this.intentSelectedColorValue,
    @required this.intentbasketPrice,
    @required this.intentbasketSelectedAttributeList,
    @required this.intentbasketSelectedAddOnList,
    @required this.selectedAddOnList,
    @required this.selectedcustomizedDetail,
    @required this.bottomSheetPrice,
    @required this.totalOriginalPrice,
    @required this.updatePrice,
    @required this.basketSelectedAttribute,
    @required this.holderBasketSelectedAddOnList,
    @required this.basketSelectedAddOn,
  }) : super(key: key);

  final AnimationController controller;
  final ProductDetailProvider productProvider;
  final BasketProvider basketProvider;
  final Product product;
  final PsValueHolder psValueHolder;
  final String intentQty;
  final String intentSelectedColorId;
  final String intentSelectedColorValue;
  final String intentbasketPrice;
  final List<BasketSelectedAttribute> intentbasketSelectedAttributeList;
  final List<BasketSelectedAddOn> intentbasketSelectedAddOnList;
  final Map<AddOn, bool> selectedAddOnList;
  final Map<String, CustomizedDetail> selectedcustomizedDetail;
  final double bottomSheetPrice;
  final double totalOriginalPrice;
  final Function updatePrice;
  final BasketSelectedAttribute basketSelectedAttribute;
  final List<BasketSelectedAddOn> holderBasketSelectedAddOnList;
  final BasketSelectedAddOn basketSelectedAddOn;

  @override
  __AddToBasketAndBuyButtonWidgetState createState() =>
      __AddToBasketAndBuyButtonWidgetState();
}

class __AddToBasketAndBuyButtonWidgetState
    extends State<_AddToBasketAndBuyButtonWidget> {
  String qty;
  String colorId = '';
  String colorValue;
  bool checkAttribute;
  Basket basket;
  String id;

  @override
  Widget build(BuildContext context) {
    final List<IconData> icons = widget.psValueHolder.phone == '' &&
            widget.psValueHolder.messenger == '' &&
            widget.psValueHolder.whatsApp == ''
        ? <IconData>[]
        : widget.psValueHolder.phone == '' &&
                widget.psValueHolder.messenger == ''
            ? <IconData>[
                FontAwesome.whatsapp,
              ]
            : widget.psValueHolder.phone == '' &&
                    widget.psValueHolder.whatsApp == ''
                ? <IconData>[
                    MaterialCommunityIcons.facebook_messenger,
                  ]
                : widget.psValueHolder.messenger == '' &&
                        widget.psValueHolder.whatsApp == ''
                    ? <IconData>[
                        Feather.phone,
                      ]
                    : widget.psValueHolder.phone == ''
                        ? <IconData>[
                            MaterialCommunityIcons.facebook_messenger,
                            FontAwesome.whatsapp,
                          ]
                        : widget.psValueHolder.messenger == ''
                            ? <IconData>[
                                FontAwesome.whatsapp,
                                Feather.phone,
                              ]
                            : widget.psValueHolder.whatsApp == ''
                                ? <IconData>[
                                    MaterialCommunityIcons.facebook_messenger,
                                    Feather.phone,
                                  ]
                                : <IconData>[
                                    MaterialCommunityIcons.facebook_messenger,
                                    FontAwesome.whatsapp,
                                    Feather.phone,
                                  ];

    final List<String> iconsLabel = widget.psValueHolder.phone == '' &&
            widget.psValueHolder.messenger == '' &&
            widget.psValueHolder.whatsApp == ''
        ? <String>[]
        : widget.psValueHolder.phone == '' &&
                widget.psValueHolder.messenger == ''
            ? <String>[
                Utils.getString(context, 'product_detail__whatsapp'),
              ]
            : widget.psValueHolder.phone == '' &&
                    widget.psValueHolder.whatsApp == ''
                ? <String>[
                    Utils.getString(context, 'product_detail__messenger')
                  ]
                : widget.psValueHolder.messenger == '' &&
                        widget.psValueHolder.whatsApp == ''
                    ? <String>[
                        Utils.getString(context, 'product_detail__call_phone')
                      ]
                    : widget.psValueHolder.phone == ''
                        ? <String>[
                            Utils.getString(
                                context, 'product_detail__messenger'),
                            Utils.getString(context, 'product_detail__whatsapp')
                          ]
                        : widget.psValueHolder.messenger == ''
                            ? <String>[
                                Utils.getString(
                                    context, 'product_detail__whatsapp'),
                                Utils.getString(
                                    context, 'product_detail__call_phone')
                              ]
                            : widget.psValueHolder.whatsApp == ''
                                ? <String>[
                                    Utils.getString(
                                        context, 'product_detail__messenger'),
                                    Utils.getString(
                                        context, 'product_detail__call_phone')
                                  ]
                                : <String>[
                                    Utils.getString(
                                        context, 'product_detail__messenger'),
                                    Utils.getString(
                                        context, 'product_detail__whatsapp'),
                                    Utils.getString(
                                        context, 'product_detail__call_phone')
                                  ];
    if (widget.intentQty != '' && (qty == null || qty == '' || qty == '0')) {
      qty = widget.intentQty;
    }
    if (widget.intentSelectedColorValue != '' &&
        widget.intentSelectedColorId != '') {
      colorId = widget.intentSelectedColorId;
      colorValue = widget.intentSelectedColorValue;
    }

    if (widget.intentbasketSelectedAttributeList != null) {
      for (int i = 0;
          i < widget.intentbasketSelectedAttributeList.length;
          i++) {
        widget.basketSelectedAttribute.addAttribute(BasketSelectedAttribute(
            headerId: widget.intentbasketSelectedAttributeList[i].headerId,
            id: widget.intentbasketSelectedAttributeList[i].id,
            name: widget.intentbasketSelectedAttributeList[i].name,
            price: widget.intentbasketSelectedAttributeList[i].price,
            currencySymbol:
                widget.intentbasketSelectedAttributeList[i].currencySymbol));
      }
    }

    if (widget.intentbasketSelectedAddOnList != null) {
      for (BasketSelectedAddOn obj in widget.intentbasketSelectedAddOnList) {
        if (widget.selectedAddOnList.isNotEmpty) {
          if (widget.selectedAddOnList[
              AddOn(id: obj.id, name: obj.name, price: obj.price)]) {
            widget.basketSelectedAddOn.addAddOn(BasketSelectedAddOn(
                id: obj.id,
                name: obj.name,
                price: obj.price,
                currencySymbol: obj.currencySymbol));
          } else {
            widget.basketSelectedAddOn.subAddOn(BasketSelectedAddOn(
                id: obj.id,
                name: obj.name,
                price: obj.price,
                currencySymbol: obj.currencySymbol));
          }
        }
      }
    }

    Future<void> updateQty(String minimumOrder) async {
      setState(() {
        qty = minimumOrder;
      });
    }

    Future<void> updateColorIdAndValue(String id, String value) async {
      colorId = id;
      colorValue = value;
    }

    Future<void> addToBasketAndBuyClickEvent(bool isBuyButtonType) async {
      if (widget.product.itemColorList.isNotEmpty &&
          widget.product.itemColorList[0].id != '') {
        if (colorId == null || colorId == '') {
          await showDialog<dynamic>(
              context: context,
              builder: (BuildContext context) {
                return WarningDialog(
                  message: Utils.getString(
                      context, 'product_detail__please_select_color'),
                  onPressed: () {},
                );
              });
          return;
        }
      }
      id =
          '${widget.product.id}$colorId${widget.basketSelectedAddOn.getSelectedaddOnIdByHeaderId()}${widget.basketSelectedAttribute.getSelectedAttributeIdByHeaderId()}';
      // Check All Attribute is selected
      if (widget.product.customizedHeaderList != null) {
        if (widget.product.customizedHeaderList.isNotEmpty &&
            widget.product.customizedHeaderList[0].id != '' &&
            widget.product.customizedHeaderList[0].customizedDetail != null &&
            // widget.product.customizedHeaderList[0].customizedDetail[0].id !=
            //     '' &&
            !widget.basketSelectedAttribute.isAllAttributeSelected(
                widget.product.customizedHeaderList.length)) {
          await showDialog<dynamic>(
              context: context,
              builder: (BuildContext context) {
                return WarningDialog(
                  message: Utils.getString(
                      context, 'product_detail__please_choose_customize'),
                  onPressed: () {},
                );
              });
          return;
        }
      }

      basket = Basket(
          id: id,
          productId: widget.product.id,
          qty: qty ?? widget.product.minimumOrder,
          shopId: widget.product.shop.id,
          selectedColorId: colorId,
          selectedColorValue: colorValue,
          basketPrice: widget.bottomSheetPrice == null
              ? widget.product.unitPrice
              : widget.bottomSheetPrice.toString(),
          basketOriginalPrice: widget.totalOriginalPrice == 0.0
              ? widget.product.originalPrice
              : widget.totalOriginalPrice.toString(),
          selectedAttributeTotalPrice: widget.basketSelectedAttribute
              .getTotalSelectedAttributePrice()
              .toString(),
          product: widget.product,
          basketSelectedAttributeList:
              widget.basketSelectedAttribute.getSelectedAttributeList(),
          basketSelectedAddOnList:
              widget.basketSelectedAddOn.getSelectedAddOnList());

      await widget.basketProvider.addBasket(basket);

      Fluttertoast.showToast(
          msg:
              Utils.getString(context, 'product_detail__success_add_to_basket'),
          toastLength: Toast.LENGTH_SHORT,
          gravity: ToastGravity.BOTTOM,
          timeInSecForIosWeb: 1,
          backgroundColor: PsColors.mainColor,
          textColor: PsColors.white);

      if (isBuyButtonType) {
        final dynamic result = await Navigator.pushNamed(
          context,
          RoutePaths.basketList,
        );
        if (result != null && result) {
          widget.productProvider
              .loadProduct(widget.product.id, widget.psValueHolder.loginUserId);
        }
      }
    }

    void _showDrawer(bool isBuyButtonType) {
      showModalBottomSheet<Widget>(
          elevation: 3.0,
          isScrollControlled: true,
          useRootNavigator: true,
          isDismissible: true,
          context: context,
          builder: (BuildContext context) {
            return Column(
              mainAxisSize: MainAxisSize.min,
              children: <Widget>[
                Row(
                  mainAxisSize: MainAxisSize.max,
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: <Widget>[
                    const SizedBox(height: PsDimens.space12),
                    Container(
                      width: PsDimens.space52,
                      height: PsDimens.space4,
                      decoration: BoxDecoration(
                        borderRadius: BorderRadius.circular(20),
                        color: PsColors.mainDividerColor,
                      ),
                    ),
                    const SizedBox(height: PsDimens.space24),
                  ],
                ),
                _ImageAndTextForBottomSheetWidget(
                  product: widget.product,
                  price: widget.bottomSheetPrice ??
                      double.parse(widget.product.unitPrice),
                ),
                Divider(height: PsDimens.space20, color: PsColors.mainColor),
                Flexible(
                  child: SingleChildScrollView(
                    child: Padding(
                      padding: const EdgeInsets.only(
                          left: PsDimens.space16,
                          right: PsDimens.space16,
                          top: PsDimens.space8,
                          bottom: PsDimens.space16),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: <Widget>[
                          _ColorsWidget(
                            product: widget.product,
                            updateColorIdAndValue: updateColorIdAndValue,
                            selectedColorId: colorId,
                          ),
                          Container(
                            margin: const EdgeInsets.only(
                                top: PsDimens.space8,
                                left: PsDimens.space12,
                                right: PsDimens.space12),
                            child: Text(
                              Utils.getString(
                                  context, 'product_detail__how_many'),
                              overflow: TextOverflow.ellipsis,
                              maxLines: 1,
                              softWrap: false,
                            ),
                          ),
                          _IconAndTextWidget(
                            product: widget.product,
                            updateQty: updateQty,
                            qty: qty,
                          ),
                          // _AttributesWidget(
                          //     product: widget.product,
                          //     updatePrice: widget.updatePrice,
                          //     basketSelectedAttribute: widget.basketSelectedAttribute,
                          //     selectedcustomizedDetail: widget.selectedcustomizedDetail),
                          const SizedBox(
                            height: PsDimens.space12,
                          ),
                          if (isBuyButtonType)
                            _AddToBasketAndBuyForBottomSheetWidget(
                              addToBasketAndBuyClickEvent:
                                  addToBasketAndBuyClickEvent,
                              isBuyButtonType: true,
                            )
                          else
                            _AddToBasketAndBuyForBottomSheetWidget(
                              addToBasketAndBuyClickEvent:
                                  addToBasketAndBuyClickEvent,
                              isBuyButtonType: false,
                            ),
                        ],
                      ),
                    ),
                  ),
                ),
              ],
            );
          });
    }

    if (widget.productProvider != null &&
        widget.productProvider.productDetail != null &&
        widget.productProvider.productDetail.data != null &&
        widget.basketProvider != null &&
        widget.basketProvider.basketList != null &&
        widget.basketProvider.basketList.data != null) {
      return Container(
        alignment: Alignment.bottomCenter,
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: <Widget>[
            Container(
              margin: const EdgeInsets.symmetric(horizontal: PsDimens.space8),
              child: _FloatingActionButton(
                icons: icons,
                label: iconsLabel,
                controller: widget.controller,
                psValueHolder: widget.psValueHolder,
              ),
            ),
            const SizedBox(height: PsDimens.space12),
            SizedBox(
              width: double.infinity,
              height: PsDimens.space72,
              child: Container(
                decoration: BoxDecoration(
                  color: PsColors.backgroundColor,
                  borderRadius: const BorderRadius.only(
                      topLeft: Radius.circular(PsDimens.space12),
                      topRight: Radius.circular(PsDimens.space12)),
                  boxShadow: <BoxShadow>[
                    BoxShadow(
                        color: PsColors.mainShadowColor,
                        offset: const Offset(0.0, 0.0),
                        spreadRadius: 0,
                        blurRadius: 15.0),
                  ],
                ),
                child: Padding(
                  padding: const EdgeInsets.all(PsDimens.space8),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                    children: <Widget>[
                      Expanded(
                        child: PSButtonWithIconWidget(
                          hasShadow: true,
                          colorData: PsColors.grey,
                          icon: Icons.add_shopping_cart,
                          width: double.infinity,
                          titleText: Utils.getString(
                              context, 'product_detail__add_to_basket'),
                          onPressed: () async {
                            if (widget.basketProvider.basketList.data
                                    .isNotEmpty &&
                                widget.product.shop.id !=
                                    widget.basketProvider.basketList.data[0]
                                        .shopId) {
                              showDialog<dynamic>(
                                  context: context,
                                  builder: (BuildContext context) {
                                    return ConfirmDialogView(
                                        description: Utils.getString(context,
                                            'warning_dialog__change_shop'),
                                        leftButtonText: Utils.getString(context,
                                            'basket_list__comfirm_dialog_cancel_button'),
                                        rightButtonText: Utils.getString(
                                            context,
                                            'basket_list__comfirm_dialog_ok_button'),
                                        onAgreeTap: () async {
                                          await widget.basketProvider
                                              .deleteWholeBasketList();
                                          Navigator.of(context).pop();
                                          _showDrawer(false);
                                        });
                                  });
                            } else {
                              if (widget.product.isAvailable == '1') {
                                if (widget.product.customizedHeaderList
                                        .isNotEmpty &&
                                    widget.product.customizedHeaderList[0].id !=
                                        '' &&
                                    widget.product.customizedHeaderList[0]
                                            .customizedDetail !=
                                        null &&
                                    widget.product.customizedHeaderList[0]
                                            .customizedDetail[0].id !=
                                        '' &&
                                    !widget.basketSelectedAttribute
                                        .isAllAttributeSelected(widget.product
                                            .customizedHeaderList.length)) {
                                  await showDialog<dynamic>(
                                      context: context,
                                      builder: (BuildContext context) {
                                        return WarningDialog(
                                          message: Utils.getString(context,
                                              'product_detail__please_choose_customize'),
                                          onPressed: () {},
                                        );
                                      });
                                } else {
                                  _showDrawer(false);
                                }
                              } else {
                                showDialog<dynamic>(
                                    context: context,
                                    builder: (BuildContext context) {
                                      return WarningDialog(
                                        message: Utils.getString(context,
                                            'product_detail__is_not_available'),
                                        onPressed: () {},
                                      );
                                    });
                              }
                            }
                          },
                        ),
                      ),
                      const SizedBox(
                        width: PsDimens.space10,
                      ),
                      Expanded(
                        child: PSButtonWithIconWidget(
                          hasShadow: true,
                          icon: Icons.shopping_cart,
                          width: double.infinity,
                          titleText:
                              Utils.getString(context, 'product_detail__buy'),
                          onPressed: () async {
                            if (widget.basketProvider.basketList.data
                                    .isNotEmpty &&
                                widget.product.shop.id !=
                                    widget.basketProvider.basketList.data[0]
                                        .shopId) {
                              showDialog<dynamic>(
                                  context: context,
                                  builder: (BuildContext context) {
                                    return ConfirmDialogView(
                                        description: Utils.getString(context,
                                            'warning_dialog__change_shop'),
                                        leftButtonText: Utils.getString(context,
                                            'basket_list__comfirm_dialog_cancel_button'),
                                        rightButtonText: Utils.getString(
                                            context,
                                            'basket_list__comfirm_dialog_ok_button'),
                                        onAgreeTap: () async {
                                          await widget.basketProvider
                                              .deleteWholeBasketList();
                                          Navigator.of(context).pop();
                                          _showDrawer(true);
                                        });
                                  });
                            } else {
                              if (widget.product.isAvailable == '1') {
                                if (widget.product.customizedHeaderList
                                        .isNotEmpty &&
                                    widget.product.customizedHeaderList[0].id !=
                                        '' &&
                                    widget.product.customizedHeaderList[0]
                                            .customizedDetail !=
                                        null &&
                                    widget.product.customizedHeaderList[0]
                                            .customizedDetail[0].id !=
                                        '' &&
                                    !widget.basketSelectedAttribute
                                        .isAllAttributeSelected(widget.product
                                            .customizedHeaderList.length)) {
                                  await showDialog<dynamic>(
                                      context: context,
                                      builder: (BuildContext context) {
                                        return WarningDialog(
                                          message: Utils.getString(context,
                                              'product_detail__please_choose_customize'),
                                          onPressed: () {},
                                        );
                                      });
                                } else {
                                  _showDrawer(true);
                                }
                              } else {
                                showDialog<dynamic>(
                                    context: context,
                                    builder: (BuildContext context) {
                                      return WarningDialog(
                                        message: Utils.getString(context,
                                            'product_detail__is_not_available'),
                                        onPressed: () {},
                                      );
                                    });
                              }
                            }
                          },
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ),
          ],
        ),
      );
    } else {
      return Container();
    }
  }
}

class _ImageAndTextForBottomSheetWidget extends StatefulWidget {
  const _ImageAndTextForBottomSheetWidget({
    Key key,
    @required this.product,
    @required this.price,
  }) : super(key: key);

  final Product product;
  final double price;
  @override
  __ImageAndTextForBottomSheetWidgetState createState() =>
      __ImageAndTextForBottomSheetWidgetState();
}

class __ImageAndTextForBottomSheetWidgetState
    extends State<_ImageAndTextForBottomSheetWidget> {
  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.only(
          left: PsDimens.space16,
          right: PsDimens.space16,
          top: PsDimens.space8),
      child: Row(
        mainAxisSize: MainAxisSize.max,
        mainAxisAlignment: MainAxisAlignment.start,
        children: <Widget>[
          Container(
            width: PsDimens.space60,
            height: PsDimens.space60,
            child: PsNetworkImage(
              photoKey: '',
              // width: PsDimens.space60,
              // height: PsDimens.space60,
              defaultPhoto: widget.product.defaultPhoto,
            ),
          ),
          const SizedBox(
            width: PsDimens.space8,
          ),
          Flexible(
            child: Column(
              mainAxisSize: MainAxisSize.min,
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              crossAxisAlignment: CrossAxisAlignment.start,
              children: <Widget>[
                Padding(
                  padding: const EdgeInsets.only(bottom: PsDimens.space8),
                  child: (widget.product.isDiscount == PsConst.ONE)
                      ? Row(
                          children: <Widget>[
                            Text(
                              widget.price != null
                                  ? '${widget.product.currencySymbol} ${Utils.getPriceFormat(widget.price.toString())}'
                                  : '${widget.product.currencySymbol} ${Utils.getPriceFormat(widget.product.unitPrice)}',
                              overflow: TextOverflow.ellipsis,
                              style: Theme.of(context)
                                  .textTheme
                                  .subtitle1
                                  .copyWith(color: PsColors.mainColor),
                            ),
                            const SizedBox(
                              width: PsDimens.space8,
                            ),
                            Text(
                              '${widget.product.currencySymbol} ${Utils.getPriceFormat(widget.product.originalPrice)}',
                              overflow: TextOverflow.ellipsis,
                              style: Theme.of(context)
                                  .textTheme
                                  .bodyText2
                                  .copyWith(
                                      decoration: TextDecoration.lineThrough),
                            )
                          ],
                        )
                      : Text(
                          widget.price != null
                              ? '${widget.product.currencySymbol} ${Utils.getPriceFormat(widget.price.toString())}'
                              : '${widget.product.currencySymbol} ${Utils.getPriceFormat(widget.product.unitPrice)}',
                          overflow: TextOverflow.ellipsis,
                          style: Theme.of(context)
                              .textTheme
                              .subtitle1
                              .copyWith(color: PsColors.mainColor),
                        ),
                ),
                const SizedBox(
                  height: PsDimens.space2,
                ),
                Text(
                  widget.product.name,
                  overflow: TextOverflow.ellipsis,
                  maxLines: 1,
                  style: Theme.of(context)
                      .textTheme
                      .caption
                      .copyWith(color: PsColors.grey),
                ),
              ],
            ),
          )
        ],
      ),
    );
  }
}

class _IconAndTextWidget extends StatefulWidget {
  const _IconAndTextWidget({
    Key key,
    @required this.product,
    @required this.updateQty,
    @required this.qty,
  }) : super(key: key);

  final Product product;
  final Function updateQty;
  final String qty;

  @override
  _IconAndTextWidgetState createState() => _IconAndTextWidgetState();
}

class _IconAndTextWidgetState extends State<_IconAndTextWidget> {
  int orderQty = 0;
  int maximumOrder = 0;
  int minimumOrder = 1; // 1 is default

  void initMinimumOrder() {
    if (widget.product.minimumOrder != null &&
        widget.product.minimumOrder != '0' &&
        widget.product.minimumOrder != '') {
      minimumOrder = int.parse(widget.product.minimumOrder);
    }
  }

  void initMaximumOrder() {
    if (widget.product.maximumOrder != null &&
        widget.product.maximumOrder != '0' &&
        widget.product.maximumOrder != '') {
      maximumOrder = int.parse(widget.product.maximumOrder);
    }
  }

  void initQty() {
    if (orderQty == 0 && widget.qty != null && widget.qty != '') {
      orderQty = int.parse(widget.qty);
    } else if (orderQty == 0) {
      orderQty = int.parse(widget.product.minimumOrder);
    }
  }

  void _increaseItemCount() {
    if (orderQty + 1 <= maximumOrder || maximumOrder == 0) {
      setState(() {
        orderQty++;
        widget.updateQty('$orderQty');
      });
    } else {
      PsToast().showToast(
          ' ${Utils.getString(context, 'product_detail__maximum_order')}  ${widget.product.maximumOrder}');
    }
  }

  void _decreaseItemCount() {
    if (orderQty != 0 && orderQty > minimumOrder) {
      orderQty--;
      setState(() {
        widget.updateQty('$orderQty');
      });
    } else {
      PsToast().showToast(
          ' ${Utils.getString(context, 'product_detail__minimum_order')}  ${widget.product.minimumOrder}');
    }
  }

  void onUpdateItemCount(int buttonType) {
    if (buttonType == 1) {
      _increaseItemCount();
    } else if (buttonType == 2) {
      _decreaseItemCount();
    }
  }

  @override
  Widget build(BuildContext context) {
    initMinimumOrder();

    initMaximumOrder();

    initQty();

    final Widget _addIconWidget = IconButton(
        iconSize: PsDimens.space32,
        icon: Icon(Icons.add_circle, color: PsColors.mainColor),
        onPressed: () {
          onUpdateItemCount(1);
        });

    final Widget _removeIconWidget = IconButton(
        iconSize: PsDimens.space32,
        icon: Icon(Icons.remove_circle, color: PsColors.grey),
        onPressed: () {
          onUpdateItemCount(2);
        });
    return Container(
      margin:
          const EdgeInsets.only(top: PsDimens.space8, bottom: PsDimens.space8),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceEvenly,
        mainAxisSize: MainAxisSize.min,
        children: <Widget>[
          _removeIconWidget,
          Center(
            child: Container(
              height: PsDimens.space24,
              alignment: Alignment.center,
              decoration: BoxDecoration(
                  border: Border.all(color: PsColors.mainDividerColor)),
              padding: const EdgeInsets.only(
                  left: PsDimens.space24, right: PsDimens.space24),
              child: Text(
                '$orderQty', //?? widget.product.minimumOrder,
                textAlign: TextAlign.center,
                style: Theme.of(context)
                    .textTheme
                    .bodyText2
                    .copyWith(color: PsColors.mainColor),
              ),
            ),
          ),
          _addIconWidget,
        ],
      ),
    );
  }
}

class _ColorsWidget extends StatefulWidget {
  const _ColorsWidget({
    Key key,
    @required this.product,
    @required this.updateColorIdAndValue,
    @required this.selectedColorId,
  }) : super(key: key);

  final Product product;
  final Function updateColorIdAndValue;
  final String selectedColorId;
  
  @override
  __ColorsWidgetState createState() => __ColorsWidgetState();
}

class __ColorsWidgetState extends State<_ColorsWidget> {
  String _selectedColorId = '';

  @override
  Widget build(BuildContext context) {
    if (_selectedColorId == '') {
      _selectedColorId = widget.selectedColorId;
    }
    if (widget.product.itemColorList.isNotEmpty &&
        widget.product.itemColorList[0].id != '') {
      return Container(
        margin: const EdgeInsets.only(
            left: PsDimens.space12, right: PsDimens.space12),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: <Widget>[
            const SizedBox(
              height: PsDimens.space4,
            ),
            Text(
              Utils.getString(context, 'product_detail__available_color'),
              overflow: TextOverflow.ellipsis,
              maxLines: 1,
              softWrap: false,
            ),
            const SizedBox(
              height: PsDimens.space4,
            ),
            Container(
              height: 50,
              child: MediaQuery.removePadding(
                  context: context,
                  removeTop: true,
                  child: ListView.builder(
                      scrollDirection: Axis.horizontal,
                      itemCount: widget.product.itemColorList.length,
                      itemBuilder: (BuildContext context, int index) {
                        return ColorListItemView(
                          color: widget.product.itemColorList[index],
                          selectedColorId: _selectedColorId,
                          onColorTap: () {
                            setState(() {
                              _selectedColorId =
                                  widget.product.itemColorList[index].id;

                              widget.updateColorIdAndValue(
                                  _selectedColorId,
                                  widget
                                      .product.itemColorList[index].colorValue);
                            });
                          },
                        );
                      })),
            ),
            const SizedBox(
              height: PsDimens.space4,
            ),
          ],
        ),
      );
    } else {
      return Container();
    }
  }
}

class _AttributesWidget extends StatefulWidget {
  const _AttributesWidget({
    Key key,
    @required this.product,
    @required this.updatePrice,
    @required this.basketSelectedAttribute,
    @required this.selectedcustomizedDetail,
    // @required this.totalPrice,
    // @required this.totalOriginalPrice
  }) : super(key: key);

  final Product product;
  final Function updatePrice;
  final BasketSelectedAttribute basketSelectedAttribute;
  final Map<String, CustomizedDetail> selectedcustomizedDetail;
  // final double totalPrice;
  // final double totalOriginalPrice;
  @override
  __AttributesWidgetState createState() => __AttributesWidgetState();
}

class __AttributesWidgetState extends State<_AttributesWidget> {
  @override
  Widget build(BuildContext context) {
    if (widget.product.customizedHeaderList.isNotEmpty &&
        widget.product.customizedHeaderList[0].id != '') {
      return Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: <Widget>[
          Container(
            margin: const EdgeInsets.only(
                top: PsDimens.space8,
                left: PsDimens.space12,
                right: PsDimens.space12,
                bottom: PsDimens.space8),
            child: Text(
              Utils.getString(context, 'product_detail__other_information'),
              overflow: TextOverflow.ellipsis,
              maxLines: 1,
              softWrap: false,
            ),
          ),
          Container(
            margin: const EdgeInsets.only(
                left: PsDimens.space8, right: PsDimens.space8),
            child: MediaQuery.removePadding(
              context: context,
              removeTop: true,
              child: ListView.builder(
                  scrollDirection: Axis.vertical,
                  physics: const NeverScrollableScrollPhysics(),
                  shrinkWrap: true,
                  itemCount: widget.product.customizedHeaderList.length,
                  itemBuilder: (BuildContext context, int index) {
                    return AttributesItemView(
                        customizedHeader:
                            widget.product.customizedHeaderList[index],
                        attributeName: widget.basketSelectedAttribute
                            .getSelectedAttributeNameByHeaderId(
                                widget.product.customizedHeaderList[index].id,
                                widget
                                    .product.customizedHeaderList[index].name),
                        onTap: () async {
                          final dynamic result = await Navigator.pushNamed(
                              context, RoutePaths.attributeDetailList,
                              arguments: AttributeDetailIntentHolder(
                                  attributeDetail: widget
                                      .product
                                      .customizedHeaderList[index]
                                      .customizedDetail,
                                  product: widget.product));

                          if (result != null && result is CustomizedDetail) {
                            // Update selected attribute
                            widget.basketSelectedAttribute.addAttribute(
                                BasketSelectedAttribute(
                                    headerId: result.headerId,
                                    id: result.id,
                                    name: result.name,
                                    price: result.additionalPrice,
                                    currencySymbol:
                                        widget.product.currencySymbol));

                            //update detil attribute in customize tile
                            widget.selectedcustomizedDetail[result.headerId] =
                                result;

                            widget.updatePrice(widget.basketSelectedAttribute);

                            // Update UI
                            setState(() {});
                          } else {}
                        });
                  }),
            ),
          ),
        ],
      );
    } else {
      return Container();
    }
  }
}

class _AddToBasketAndBuyForBottomSheetWidget extends StatefulWidget {
  const _AddToBasketAndBuyForBottomSheetWidget({
    Key key,
    @required this.addToBasketAndBuyClickEvent,
    @required this.isBuyButtonType,
  }) : super(key: key);

  final Function addToBasketAndBuyClickEvent;
  final bool isBuyButtonType;
  @override
  __AddToBasketAndBuyForBottomSheetWidgetState createState() =>
      __AddToBasketAndBuyForBottomSheetWidgetState();
}

class __AddToBasketAndBuyForBottomSheetWidgetState
    extends State<_AddToBasketAndBuyForBottomSheetWidget> {
  @override
  Widget build(BuildContext context) {
    if (widget.isBuyButtonType) {
      return Container(
        width: double.infinity,
        margin: const EdgeInsets.only(
            right: PsDimens.space16,
            left: PsDimens.space16,
            bottom: PsDimens.space16),
        child: PSButtonWithIconWidget(
            hasShadow: true,
            icon: Icons.shopping_cart,
            width: double.infinity,
            titleText: Utils.getString(context, 'product_detail__buy'),
            onPressed: () async {
              widget.addToBasketAndBuyClickEvent(true);
            }),
      );
    } else {
      return Container(
        width: double.infinity,
        margin: const EdgeInsets.only(
            right: PsDimens.space16,
            left: PsDimens.space16,
            bottom: PsDimens.space16),
        child: PSButtonWithIconWidget(
            hasShadow: true,
            icon: Icons.add_shopping_cart,
            width: double.infinity,
            titleText:
                Utils.getString(context, 'product_detail__add_to_basket'),
            onPressed: () async {
              widget.addToBasketAndBuyClickEvent(false);
            }),
      );
    }
  }
}

class _FloatingActionButton extends StatefulWidget {
  const _FloatingActionButton({
    Key key,
    @required this.controller,
    @required this.icons,
    @required this.label,
    @required this.psValueHolder,
  }) : super(key: key);

  final AnimationController controller;
  final List<IconData> icons;
  final List<String> label;
  final PsValueHolder psValueHolder;
  @override
  __FloatingActionButtonState createState() => __FloatingActionButtonState();
}

class __FloatingActionButtonState extends State<_FloatingActionButton> {
  @override
  Widget build(BuildContext context) {
    final String whatsappUrl = 'https://wa.me/${widget.psValueHolder.whatsApp}';
    final String messengerUrl = 'http://m.me/${widget.psValueHolder.messenger}';
    final String phoneCall = 'tel://${widget.psValueHolder.phone}';

    if (widget.icons.isNotEmpty && widget.label.isNotEmpty) {
      return Column(
        mainAxisSize: MainAxisSize.min,
        mainAxisAlignment: MainAxisAlignment.end,
        crossAxisAlignment: CrossAxisAlignment.end,
        children: List<Widget>.generate(widget.icons.length, (int index) {
          Widget _getChip() {
            return Chip(
              backgroundColor: PsColors.mainColor,
              label: InkWell(
                onTap: () async {
                  print(index);

                  if (await canLaunch(index == 0
                      ? messengerUrl
                      : index == 1
                          ? whatsappUrl
                          : phoneCall)) {
                    await launch(
                        index == 0
                            ? messengerUrl
                            : index == 1
                                ? whatsappUrl
                                : phoneCall,
                        forceSafariVC: false);
                  } else {
                    throw whatsappUrl;
                  }
                },
                child: Text(
                  widget.label[index],
                  textAlign: TextAlign.center,
                  overflow: TextOverflow.ellipsis,
                  style: TextStyle(
                    color: PsColors.white,
                  ),
                ),
              ),
            );
          }

          final Widget child = Row(
            mainAxisAlignment: MainAxisAlignment.end,
            crossAxisAlignment: CrossAxisAlignment.end,
            children: <Widget>[
              Container(
                margin: const EdgeInsets.symmetric(horizontal: PsDimens.space8),
                child: ScaleTransition(
                  scale: CurvedAnimation(
                    parent: widget.controller,
                    curve:
                        Interval((index + 1) / 10, 1.0, curve: Curves.easeIn),
                  ),
                  child: _getChip(),
                ),
              ),
              Container(
                margin: const EdgeInsets.symmetric(
                    horizontal: PsDimens.space4, vertical: PsDimens.space2),
                child: ScaleTransition(
                  scale: CurvedAnimation(
                    parent: widget.controller,
                    curve: Interval(
                        0.0, 1.0 - index / widget.icons.length / 2.0,
                        curve: Curves.easeIn),
                  ),
                  child: FloatingActionButton(
                    heroTag: widget.label[index],
                    backgroundColor: PsColors.mainColor,
                    mini: true,
                    child: Icon(widget.icons[index], color: PsColors.white),
                    onPressed: () async {
                      print(index);
                      if (await canLaunch(index == 0
                          ? messengerUrl
                          : index == 1
                              ? whatsappUrl
                              : phoneCall)) {
                        await launch(
                            index == 0
                                ? messengerUrl
                                : index == 1
                                    ? whatsappUrl
                                    : phoneCall,
                            forceSafariVC: false);
                      } else {
                        throw whatsappUrl;
                      }
                    },
                  ),
                ),
              ),
            ],
          );
          return child;
        }).toList()
          ..add(
            Container(
              margin: const EdgeInsets.only(top: PsDimens.space8),
              child: FloatingActionButton(
                backgroundColor: PsColors.mainColor,
                child: AnimatedBuilder(
                  animation: widget.controller,
                  child: Icon(
                    widget.controller.isDismissed ? Icons.sms : Icons.sms,
                    color: PsColors.white,
                  ),
                  builder: (BuildContext context, Widget child) {
                    return Transform(
                      transform:
                          Matrix4.rotationZ(widget.controller.value * 0.5 * 8),
                      alignment: FractionalOffset.center,
                      child: child,
                    );
                  },
                ),
                onPressed: () {
                  if (widget.controller.isDismissed) {
                    widget.controller.forward();
                  } else {
                    widget.controller.reverse();
                  }
                },
              ),
            ),
          ),
      );
    } else {
      return Container();
    }
  }
}
