import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/constant/route_paths.dart';
import 'package:fluttermultigrocery/provider/product/product_provider.dart';
import 'package:fluttermultigrocery/ui/common/ps_expansion_tile.dart';
import 'package:fluttermultigrocery/ui/product/detail/views/color_list_item_view.dart';
import 'package:fluttermultigrocery/ui/product/item/nutrient_horizontal_list_item.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/product_list_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/product_parameter_holder.dart';
import 'package:fluttermultigrocery/viewobject/product.dart';

class DetailInfoTileView extends StatelessWidget {
  const DetailInfoTileView({
    Key key,
    @required this.productDetail,
  }) : super(key: key);

  final ProductDetailProvider productDetail;

  @override
  Widget build(BuildContext context) {
    final Widget _expansionTileTitleWidget = Text(
        Utils.getString(context, 'detail_info_tile__detail_info'),
        style: Theme.of(context).textTheme.subtitle1);
    final List<String> nutrientList =
        productDetail.productDetail.data.nutrient.split(',');
    if (productDetail != null &&
        productDetail.productDetail != null &&
        productDetail.productDetail.data != null) {
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
            Padding(
              padding: const EdgeInsets.only(
                  bottom: PsDimens.space16,
                  left: PsDimens.space32,
                  right: PsDimens.space16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: <Widget>[
                  Text(
                    Utils.getString(context, 'detail_info_tile__ingredient'),
                    style: Theme.of(context).textTheme.bodyText1,
                  ),
                  const SizedBox(height: PsDimens.space8),
                  Padding(
                    padding: const EdgeInsets.only(left: PsDimens.space16),
                    child: Text(
                      productDetail.productDetail.data.ingredient,
                      style: Theme.of(context).textTheme.bodyText2,
                    ),
                  ),
                  if (nutrientList.isNotEmpty &&
                      productDetail.productDetail.data.nutrient != '')
                    Column(
                      crossAxisAlignment: CrossAxisAlignment.stretch,
                      children: <Widget>[
                        const SizedBox(height: PsDimens.space16),
                        Text(
                          Utils.getString(
                              context, 'detail_info_tile__nutrient'),
                          style: Theme.of(context).textTheme.bodyText1,
                        ),
                        const SizedBox(height: PsDimens.space8),
                        _NutrientWidget(
                          nutrientList: nutrientList,
                          productDetailProvider: productDetail,
                        ),
                      ],
                    )
                ],
              ),
            )
          ],
        ),
      );
    } else {
      return const Card();
    }
  }
}

class _NutrientWidget extends StatelessWidget {
  const _NutrientWidget({
    Key key,
    @required this.nutrientList,
    @required this.productDetailProvider,
  }) : super(key: key);

  final List<String> nutrientList;
  final ProductDetailProvider productDetailProvider;

  @override
  Widget build(BuildContext context) {
    return Container(
      height: PsDimens.space40,
      child: CustomScrollView(
          scrollDirection: Axis.horizontal,
          shrinkWrap: true,
          slivers: <Widget>[
            SliverList(
              delegate:
                  SliverChildBuilderDelegate((BuildContext context, int index) {
                if (nutrientList != null) {
                  return NutrientHorizontalListItem(
                    nutrientName: nutrientList[index],
                    onTap: () async {
                      final ProductParameterHolder productParameterHolder =
                          ProductParameterHolder().resetParameterHolder();

                      if (index == 0) {
                        productParameterHolder.catId =
                            productDetailProvider.productDetail.data.catId;
                      } else if (index == 1) {
                        productParameterHolder.catId =
                            productDetailProvider.productDetail.data.catId;
                        productParameterHolder.subCatId =
                            productDetailProvider.productDetail.data.subCatId;
                      } else {
                        productParameterHolder.searchTerm = nutrientList[index];
                      }
                      print('productParameterHolder.catId ' +
                          productParameterHolder.catId +
                          'productParameterHolder.subCatId ' +
                          productParameterHolder.subCatId +
                          'productParameterHolder.searchTerm ' +
                          productParameterHolder.searchTerm);
                      Navigator.pushNamed(context, RoutePaths.filterProductList,
                          arguments: ProductListIntentHolder(
                            appBarTitle: nutrientList[index],
                            productParameterHolder: productParameterHolder,
                          ));
                    },
                  );
                } else {
                  return null;
                }
              }, childCount: nutrientList.length),
            ),
          ]),
    );
  }
}

class _ColorsWidget extends StatefulWidget {
  const _ColorsWidget({
    Key key,
    @required this.product,
  }) : super(key: key);

  final Product product;
  @override
  __ColorsWidgetState createState() => __ColorsWidgetState();
}

class __ColorsWidgetState extends State<_ColorsWidget> {
  @override
  Widget build(BuildContext context) {
    if (widget.product.itemColorList.isNotEmpty &&
        widget.product.itemColorList[0].id != '') {
      return Column(
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
            style: Theme.of(context).textTheme.bodyText1,
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
                        selectedColorId: '',
                        onColorTap: () {},
                      );
                    })),
          ),
        ],
      );
    } else {
      return Container();
    }
  }
}
