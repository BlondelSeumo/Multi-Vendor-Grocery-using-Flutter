import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/provider/product/search_product_provider.dart';
import 'package:fluttermultigrocery/repository/product_repository.dart';
import 'package:fluttermultigrocery/ui/common/base/ps_widget_with_appbar.dart';
import 'package:fluttermultigrocery/ui/common/ps_button_widget.dart';
import 'package:fluttermultigrocery/ui/common/ps_special_check_text_widget.dart';
import 'package:fluttermultigrocery/ui/common/ps_textfield_widget.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/holder/product_parameter_holder.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_icons/flutter_icons.dart';
import 'package:provider/provider.dart';

class ItemSearchView extends StatefulWidget {
  const ItemSearchView({
    @required this.productParameterHolder,
  });

  final ProductParameterHolder productParameterHolder;

  @override
  _ItemSearchViewState createState() => _ItemSearchViewState();
}

class _ItemSearchViewState extends State<ItemSearchView> {
  ProductRepository repo1;
  SearchProductProvider _searchProductProvider;

  final TextEditingController userInputItemNameTextEditingController =
      TextEditingController();
  final TextEditingController userInputMaximunPriceEditingController =
      TextEditingController();
  final TextEditingController userInputMinimumPriceEditingController =
      TextEditingController();

  @override
  Widget build(BuildContext context) {
    print(
        '............................Build UI Again ............................');

    final Widget _searchButtonWidget = PSButtonWidget(
      hasShadow: true,
      width: double.infinity,
      titleText: Utils.getString(context, 'home_search__search'),
      onPressed: () {
        if (userInputItemNameTextEditingController.text != null) {
          _searchProductProvider.productParameterHolder.searchTerm =
              userInputItemNameTextEditingController.text;
        } else {
          _searchProductProvider.productParameterHolder.searchTerm = '';
        }
        if (userInputMaximunPriceEditingController.text != null) {
          _searchProductProvider.productParameterHolder.maxPrice =
              userInputMaximunPriceEditingController.text;
        } else {
          _searchProductProvider.productParameterHolder.maxPrice = '';
        }
        if (userInputMinimumPriceEditingController.text != null) {
          _searchProductProvider.productParameterHolder.minPrice =
              userInputMinimumPriceEditingController.text;
        } else {
          _searchProductProvider.productParameterHolder.minPrice = '';
        }
        if (_searchProductProvider.isfirstRatingClicked) {
          _searchProductProvider.productParameterHolder.overallRating =
              PsConst.RATING_ONE;
        }

        if (_searchProductProvider.isSecondRatingClicked) {
          _searchProductProvider.productParameterHolder.overallRating =
              PsConst.RATING_TWO;
        }

        if (_searchProductProvider.isThirdRatingClicked) {
          _searchProductProvider.productParameterHolder.overallRating =
              PsConst.RATING_THREE;
        }

        if (_searchProductProvider.isfouthRatingClicked) {
          _searchProductProvider.productParameterHolder.overallRating =
              PsConst.RATING_FOUR;
        }

        if (_searchProductProvider.isFifthRatingClicked) {
          _searchProductProvider.productParameterHolder.overallRating =
              PsConst.RATING_FIVE;
        }

        if (!_searchProductProvider.isfirstRatingClicked &&
            !_searchProductProvider.isSecondRatingClicked &&
            !_searchProductProvider.isThirdRatingClicked &&
            !_searchProductProvider.isfouthRatingClicked &&
            !_searchProductProvider.isFifthRatingClicked) {
          _searchProductProvider.productParameterHolder.overallRating = '';
        }

        if (_searchProductProvider.isSwitchedFeaturedProduct) {
          _searchProductProvider.productParameterHolder.isFeatured =
              PsConst.IS_FEATURED;
        } else {
          _searchProductProvider.productParameterHolder.isFeatured =
              PsConst.ZERO;
        }

        if (_searchProductProvider.isSwitchedDiscountPrice) {
          _searchProductProvider.productParameterHolder.isDiscount =
              PsConst.IS_DISCOUNT;
        } else {
          _searchProductProvider.productParameterHolder.isDiscount =
              PsConst.ZERO;
        }

        print('userInputText' + userInputItemNameTextEditingController.text);

        Navigator.pop(context, _searchProductProvider.productParameterHolder);
      },
    );

    repo1 = Provider.of<ProductRepository>(context);

    return PsWidgetWithAppBar<SearchProductProvider>(
        appBarTitle:
            Utils.getString(context, 'item_filter__filtered_by_product_type') ??
                '',
        initProvider: () {
          return SearchProductProvider(repo: repo1);
        },
        onProviderReady: (SearchProductProvider provider) {
          _searchProductProvider = provider;
          _searchProductProvider.productParameterHolder =
              widget.productParameterHolder;

          userInputItemNameTextEditingController.text =
              widget.productParameterHolder.searchTerm;
          userInputMinimumPriceEditingController.text =
              widget.productParameterHolder.minPrice;
          userInputMaximunPriceEditingController.text =
              widget.productParameterHolder.maxPrice;

          if (widget.productParameterHolder.overallRating ==
              PsConst.RATING_ONE) {
            _searchProductProvider.isfirstRatingClicked = true;
          } else if (widget.productParameterHolder.overallRating ==
              PsConst.RATING_TWO) {
            _searchProductProvider.isSecondRatingClicked = true;
          } else if (widget.productParameterHolder.overallRating ==
              PsConst.RATING_THREE) {
            _searchProductProvider.isThirdRatingClicked = true;
          } else if (widget.productParameterHolder.overallRating ==
              PsConst.RATING_FOUR) {
            _searchProductProvider.isfouthRatingClicked = true;
          } else if (widget.productParameterHolder.overallRating ==
              PsConst.RATING_FIVE) {
            _searchProductProvider.isFifthRatingClicked = true;
          }

          if (widget.productParameterHolder.isDiscount == PsConst.ONE) {
            _searchProductProvider.isSwitchedDiscountPrice = true;
          } else {
            _searchProductProvider.isSwitchedDiscountPrice = false;
          }
          if (widget.productParameterHolder.isFeatured == PsConst.ONE) {
            _searchProductProvider.isSwitchedFeaturedProduct = true;
          } else {
            _searchProductProvider.isSwitchedFeaturedProduct = false;
          }
        },
        actions: <Widget>[
          IconButton(
              icon: Icon(MaterialCommunityIcons.filter_remove_outline,
                  color: PsColors.mainColor),
              onPressed: () {
                print('Click Clear Button');
                userInputItemNameTextEditingController.text = '';
                userInputMaximunPriceEditingController.text = '';
                userInputMinimumPriceEditingController.text = '';
                _searchProductProvider.isfirstRatingClicked = false;
                _searchProductProvider.isSecondRatingClicked = false;
                _searchProductProvider.isThirdRatingClicked = false;
                _searchProductProvider.isfouthRatingClicked = false;
                _searchProductProvider.isFifthRatingClicked = false;

                _searchProductProvider.isSwitchedFeaturedProduct = false;
                _searchProductProvider.isSwitchedDiscountPrice = false;
                setState(() {});
              }),
        ],
        builder: (BuildContext context, SearchProductProvider provider,
            Widget child) {
          return CustomScrollView(
            scrollDirection: Axis.vertical,
            slivers: <Widget>[
              SliverToBoxAdapter(
                child: SingleChildScrollView(
                  child: Container(
                    child: Column(
                      children: <Widget>[
                        _ProductNameWidget(
                          userInputItemNameTextEditingController:
                              userInputItemNameTextEditingController,
                        ),
                        _PriceWidget(
                          userInputMinimumPriceEditingController:
                              userInputMinimumPriceEditingController,
                          userInputMaximunPriceEditingController:
                              userInputMaximunPriceEditingController,
                        ),
                        _RatingRangeWidget(),
                        _SpecialCheckWidget(),
                        Container(
                          margin: const EdgeInsets.only(
                              left: PsDimens.space16,
                              top: PsDimens.space16,
                              right: PsDimens.space16,
                              bottom: PsDimens.space40),
                          child: _searchButtonWidget,
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
}

dynamic setAllRatingFalse(SearchProductProvider provider) {
  provider.isfirstRatingClicked = false;
  provider.isSecondRatingClicked = false;
  provider.isThirdRatingClicked = false;
  provider.isfouthRatingClicked = false;
  provider.isFifthRatingClicked = false;
}

class _ProductNameWidget extends StatefulWidget {
  const _ProductNameWidget({this.userInputItemNameTextEditingController});
  final TextEditingController userInputItemNameTextEditingController;
  @override
  __ProductNameWidgetState createState() => __ProductNameWidgetState();
}

class __ProductNameWidgetState extends State<_ProductNameWidget> {
  @override
  Widget build(BuildContext context) {
    print('*****' + widget.userInputItemNameTextEditingController.text);
    return Column(
      children: <Widget>[
        PsTextFieldWidget(
            titleText: Utils.getString(context, 'home_search__product_name'),
            hintText: Utils.getString(context, 'home_search__not_set'),
            textEditingController:
                widget.userInputItemNameTextEditingController),
      ],
    );
  }
}

class _ChangeRatingColor extends StatelessWidget {
  const _ChangeRatingColor({
    Key key,
    @required this.title,
    @required this.checkColor,
  }) : super(key: key);

  final String title;
  final bool checkColor;

  @override
  Widget build(BuildContext context) {
    final Color defaultBackgroundColor = PsColors.backgroundColor;
    return Container(
      width: MediaQuery.of(context).size.width / 5.5,
      height: PsDimens.space104,
      decoration: BoxDecoration(
        color: checkColor ? defaultBackgroundColor : PsColors.mainColor,
      ),
      child: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          mainAxisSize: MainAxisSize.max,
          children: <Widget>[
            Icon(
              Icons.star,
              color: checkColor ? PsColors.iconColor : PsColors.white,
            ),
            const SizedBox(
              height: PsDimens.space2,
            ),
            Text(
              title,
              textAlign: TextAlign.center,
              style: Theme.of(context).textTheme.caption.copyWith(
                    color: checkColor ? PsColors.iconColor : PsColors.white,
                  ),
            ),
          ],
        ),
      ),
    );
  }
}

class _RatingRangeWidget extends StatefulWidget {
  @override
  __RatingRangeWidgetState createState() => __RatingRangeWidgetState();
}

class __RatingRangeWidgetState extends State<_RatingRangeWidget> {
  @override
  Widget build(BuildContext context) {
    final SearchProductProvider provider =
        Provider.of<SearchProductProvider>(context);

    dynamic _firstRatingRangeSelected() {
      if (!provider.isfirstRatingClicked) {
        return _ChangeRatingColor(
          title: Utils.getString(context, 'home_search__one_and_higher'),
          checkColor: true,
        );
      } else {
        return _ChangeRatingColor(
          title: Utils.getString(context, 'home_search__one_and_higher'),
          checkColor: false,
        );
      }
    }

    dynamic _secondRatingRangeSelected() {
      if (!provider.isSecondRatingClicked) {
        return _ChangeRatingColor(
          title: Utils.getString(context, 'home_search__two_and_higher'),
          checkColor: true,
        );
      } else {
        return _ChangeRatingColor(
          title: Utils.getString(context, 'home_search__two_and_higher'),
          checkColor: false,
        );
      }
    }

    dynamic _thirdRatingRangeSelected() {
      if (!provider.isThirdRatingClicked) {
        return _ChangeRatingColor(
          title: Utils.getString(context, 'home_search__three_and_higher'),
          checkColor: true,
        );
      } else {
        return _ChangeRatingColor(
          title: Utils.getString(context, 'home_search__three_and_higher'),
          checkColor: false,
        );
      }
    }

    dynamic _fouthRatingRangeSelected() {
      if (!provider.isfouthRatingClicked) {
        return _ChangeRatingColor(
          title: Utils.getString(context, 'home_search__four_and_higher'),
          checkColor: true,
        );
      } else {
        return _ChangeRatingColor(
          title: Utils.getString(context, 'home_search__four_and_higher'),
          checkColor: false,
        );
      }
    }

    dynamic _fifthRatingRangeSelected() {
      if (!provider.isFifthRatingClicked) {
        return _ChangeRatingColor(
          title: Utils.getString(context, 'home_search__five'),
          checkColor: true,
        );
      } else {
        return _ChangeRatingColor(
          title: Utils.getString(context, 'home_search__five'),
          checkColor: false,
        );
      }
    }

    return Column(
      mainAxisSize: MainAxisSize.max,
      children: <Widget>[
        Container(
          width: double.infinity,
          margin: const EdgeInsets.all(PsDimens.space12),
          child: Text(Utils.getString(context, 'home_search__rating_range'),
              style: Theme.of(context).textTheme.bodyText1),
        ),
        Row(
          mainAxisAlignment: MainAxisAlignment.center,
          mainAxisSize: MainAxisSize.max,
          children: <Widget>[
            Container(
              width: MediaQuery.of(context).size.width / 5.5,
              decoration: const BoxDecoration(),
              child: InkWell(
                onTap: () {
                  if (!provider.isfirstRatingClicked) {
                    provider.isfirstRatingClicked = true;
                    provider.isSecondRatingClicked = false;
                    provider.isThirdRatingClicked = false;
                    provider.isfouthRatingClicked = false;
                    provider.isFifthRatingClicked = false;
                  } else {
                    setAllRatingFalse(provider);
                  }

                  setState(() {});
                },
                child: _firstRatingRangeSelected(),
              ),
            ),
            Container(
              margin: const EdgeInsets.all(PsDimens.space4),
              width: MediaQuery.of(context).size.width / 5.5,
              decoration: const BoxDecoration(),
              child: InkWell(
                onTap: () {
                  if (!provider.isSecondRatingClicked) {
                    provider.isfirstRatingClicked = false;
                    provider.isSecondRatingClicked = true;
                    provider.isThirdRatingClicked = false;
                    provider.isfouthRatingClicked = false;
                    provider.isFifthRatingClicked = false;
                  } else {
                    setAllRatingFalse(provider);
                  }

                  setState(() {});
                },
                child: _secondRatingRangeSelected(),
              ),
            ),
            Container(
              width: MediaQuery.of(context).size.width / 5.5,
              decoration: const BoxDecoration(),
              child: InkWell(
                onTap: () {
                  if (!provider.isThirdRatingClicked) {
                    provider.isfirstRatingClicked = false;
                    provider.isSecondRatingClicked = false;
                    provider.isThirdRatingClicked = true;
                    provider.isfouthRatingClicked = false;
                    provider.isFifthRatingClicked = false;
                  } else {
                    setAllRatingFalse(provider);
                  }

                  setState(() {});
                },
                child: _thirdRatingRangeSelected(),
              ),
            ),
            Container(
              margin: const EdgeInsets.all(PsDimens.space4),
              width: MediaQuery.of(context).size.width / 5.5,
              decoration: const BoxDecoration(),
              child: InkWell(
                onTap: () {
                  if (!provider.isfouthRatingClicked) {
                    provider.isfirstRatingClicked = false;
                    provider.isSecondRatingClicked = false;
                    provider.isThirdRatingClicked = false;
                    provider.isfouthRatingClicked = true;
                    provider.isFifthRatingClicked = false;
                  } else {
                    setAllRatingFalse(provider);
                  }

                  setState(() {});
                },
                child: _fouthRatingRangeSelected(),
              ),
            ),
            Container(
              width: MediaQuery.of(context).size.width / 5.5,
              child: InkWell(
                onTap: () {
                  if (!provider.isFifthRatingClicked) {
                    provider.isfirstRatingClicked = false;
                    provider.isSecondRatingClicked = false;
                    provider.isThirdRatingClicked = false;
                    provider.isfouthRatingClicked = false;
                    provider.isFifthRatingClicked = true;
                  } else {
                    setAllRatingFalse(provider);
                  }

                  setState(() {});
                },
                child: _fifthRatingRangeSelected(),
              ),
            ),
          ],
        ),
      ],
    );
  }
}

class _PriceWidget extends StatelessWidget {
  const _PriceWidget(
      {this.userInputMinimumPriceEditingController,
      this.userInputMaximunPriceEditingController});
  final TextEditingController userInputMinimumPriceEditingController;
  final TextEditingController userInputMaximunPriceEditingController;
  @override
  Widget build(BuildContext context) {
    return Column(
      children: <Widget>[
        Container(
          width: double.infinity,
          margin: const EdgeInsets.all(PsDimens.space12),
          child: Text(Utils.getString(context, 'home_search__price'),
              style: Theme.of(context).textTheme.bodyText1),
        ),
        _PriceTextWidget(
          title: Utils.getString(context, 'home_search__lowest_price'),
          textField: TextField(
            maxLines: null,
            style: Theme.of(context).textTheme.bodyText2,
            decoration: InputDecoration(
                contentPadding: const EdgeInsets.only(
                    left: PsDimens.space8, bottom: PsDimens.space12),
                border: InputBorder.none,
                hintText: Utils.getString(context, 'home_search__not_set'),
                hintStyle: Theme.of(context)
                    .textTheme
                    .bodyText2
                    .copyWith(color: PsColors.textPrimaryLightColor)),
            keyboardType: TextInputType.number,
            controller: userInputMinimumPriceEditingController,
          ),
        ),
        const Divider(
          height: PsDimens.space1,
        ),
        _PriceTextWidget(
          title: Utils.getString(context, 'home_search__highest_price'),
          textField: TextField(
            maxLines: null,
            style: Theme.of(context).textTheme.bodyText2,
            decoration: InputDecoration(
                contentPadding: const EdgeInsets.only(
                    left: PsDimens.space8, bottom: PsDimens.space12),
                border: InputBorder.none,
                hintText: Utils.getString(context, 'home_search__not_set'),
                hintStyle: Theme.of(context)
                    .textTheme
                    .bodyText2
                    .copyWith(color: PsColors.textPrimaryLightColor)),
            keyboardType: TextInputType.number,
            controller: userInputMaximunPriceEditingController,
          ),
        ),
      ],
    );
  }
}

class _PriceTextWidget extends StatelessWidget {
  const _PriceTextWidget({
    Key key,
    @required this.title,
    @required this.textField,
  }) : super(key: key);

  final String title;
  final TextField textField;

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      color: PsColors.backgroundColor,
      child: Container(
        margin: const EdgeInsets.all(PsDimens.space12),
        alignment: Alignment.centerLeft,
        child: Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: <Widget>[
            Text(
              title,
              style: Theme.of(context).textTheme.bodyText2,
            ),
            Container(
                decoration: BoxDecoration(
                    color: PsColors.backgroundColor,
                    borderRadius: BorderRadius.circular(PsDimens.space4),
                    border: Border.all(color: PsColors.mainDividerColor)),
                width: PsDimens.space120,
                height: PsDimens.space36,
                child: textField),
          ],
        ),
      ),
    );
  }
}

class _SpecialCheckWidget extends StatefulWidget {
  @override
  __SpecialCheckWidgetState createState() => __SpecialCheckWidgetState();
}

class __SpecialCheckWidgetState extends State<_SpecialCheckWidget> {
  @override
  Widget build(BuildContext context) {
    return Column(
      children: <Widget>[
        Container(
          margin: const EdgeInsets.all(PsDimens.space12),
          width: double.infinity,
          child: Text(Utils.getString(context, 'home_search__special_check'),
              style: Theme.of(context).textTheme.bodyText1),
        ),
        SpecialCheckTextWidget(
            title: Utils.getString(context, 'home_search__featured_product'),
            icon: FontAwesome5.gem,
            checkTitle: 1,
            size: PsDimens.space18),
        const Divider(
          height: PsDimens.space1,
        ),
        SpecialCheckTextWidget(
            title: Utils.getString(context, 'home_search__discount_price'),
            icon: Feather.percent,
            checkTitle: 2,
            size: PsDimens.space18),
        const Divider(
          height: PsDimens.space1,
        ),
      ],
    );
  }
}
