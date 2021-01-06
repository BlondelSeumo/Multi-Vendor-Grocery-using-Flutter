import 'package:carousel_slider/carousel_slider.dart';
import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/ui/common/ps_ui_widget.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/viewobject/product_collection_header.dart';

class CollectionProductSliderView extends StatefulWidget {
  const CollectionProductSliderView({
    Key key,
    @required this.collectionProductList,
    this.onTap,
  }) : super(key: key);

  final Function onTap;
  final List<ProductCollectionHeader> collectionProductList;

  @override
  _CollectionProductSliderState createState() =>
      _CollectionProductSliderState();
}

class _CollectionProductSliderState extends State<CollectionProductSliderView> {
  String _currentId;
  @override
  Widget build(BuildContext context) {
    return Stack(
      children: <Widget>[
        if (widget.collectionProductList != null &&
            widget.collectionProductList.isNotEmpty)
          CarouselSlider(
            options: CarouselOptions(
                enlargeCenterPage: true,
                autoPlay: false,
                viewportFraction: 0.9,
                autoPlayInterval: const Duration(seconds: 5),
                onPageChanged: (int i, CarouselPageChangedReason reason) {
                  setState(() {
                    _currentId = widget.collectionProductList[i].id;
                  });
                }),

            items: widget.collectionProductList
                .map((ProductCollectionHeader collectionProduct) {
              return Container(
                decoration: BoxDecoration(
                  border: Border.all(
                    color: PsColors.mainLightShadowColor,
                  ),
                  borderRadius:
                      const BorderRadius.all(Radius.circular(PsDimens.space8)),
                  boxShadow: <BoxShadow>[
                    BoxShadow(
                        color: PsColors.mainLightShadowColor,
                        offset: const Offset(1.1, 1.1),
                        blurRadius: PsDimens.space8),
                  ],
                ),
                child: Stack(
                  children: <Widget>[
                    ClipRRect(
                      borderRadius: BorderRadius.circular(PsDimens.space8),
                      child: PsNetworkImage(
                          photoKey: '',
                          defaultPhoto: collectionProduct.defaultPhoto,
                          width: MediaQuery.of(context).size.width,
                          height: double.infinity,
                          boxfit: BoxFit.cover,
                          onTap: () {
                            widget.onTap(collectionProduct);
                          }),
                    ),
                  ],
                ),
              );
            }).toList(),
            // onPageChanged: (int i) {
            //   setState(() {
            //     _currentId = widget.collectionProductList[i].id;
            //   });
            // },
          )
        else
          Container(),
        Positioned(
            bottom: 5.0,
            left: 0.0,
            right: 0.0,
            child: Row(
              mainAxisSize: MainAxisSize.min,
              mainAxisAlignment: MainAxisAlignment.center,
              children: widget.collectionProductList != null &&
                      widget.collectionProductList.isNotEmpty
                  ? widget.collectionProductList
                      .map((ProductCollectionHeader collectionProduct) {
                      return Builder(builder: (BuildContext context) {
                        return Container(
                            width: 8.0,
                            height: 8.0,
                            margin: const EdgeInsets.symmetric(
                                vertical: 10.0, horizontal: 2.0),
                            decoration: BoxDecoration(
                                shape: BoxShape.circle,
                                color: _currentId == collectionProduct.id
                                    ? PsColors.mainColor
                                    : PsColors.grey));
                      });
                    }).toList()
                  : <Widget>[Container()],
            ))
      ],
    );
  }
}
