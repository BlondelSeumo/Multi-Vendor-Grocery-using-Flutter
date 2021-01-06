import 'package:flutter/material.dart';
import 'package:flutter_icons/flutter_icons.dart';
import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/constant/route_paths.dart';
import 'package:fluttermultigrocery/ui/collection/dashboard/dashboard_collection_header_list_view.dart';
import 'package:fluttermultigrocery/ui/common/ps_textfield_with_icon_widget.dart';
import 'package:fluttermultigrocery/ui/dashboard/home/product_list_view.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/category.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_value_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/intent_holder/product_list_intent_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/product_parameter_holder.dart';

class HomeTabbarProductListView extends StatefulWidget {
  const HomeTabbarProductListView({
    Key key,
    @required this.shopId,
    @required this.shopName,
    @required this.categoryList,
    @required this.userInputItemNameTextEditingController,
    @required this.valueHolder,
  }) : super(key: key);

  final String shopId;
  final String shopName;
  final List<Category> categoryList;
  final TextEditingController userInputItemNameTextEditingController;
  final PsValueHolder valueHolder;

  @override
  _HomeTabbarProductListViewState createState() =>
      _HomeTabbarProductListViewState();
}

class _HomeTabbarProductListViewState extends State<HomeTabbarProductListView>
    with TickerProviderStateMixin {
  // TickerProviderStateMixin allows the fade out/fade in animation when changing the active button

  // this will control the button clicks and tab changing
  TabController _controller;

  // this will control the animation when a button changes from an off state to an on state
  AnimationController _animationControllerOn;

  // this will control the animation when a button changes from an on state to an off state
  AnimationController _animationControllerOff;

  // this will give the background color values of a button when it changes to an on state
  Animation<dynamic> _colorTweenBackgroundOn;
  Animation<dynamic> _colorTweenBackgroundOff;

  // when swiping, the _controller.index value only changes after the animation, therefore, we need this to trigger the animations and save the current index
  int _currentIndex = 0;

  // saves the previous active tab
  int _prevControllerIndex = 0;

  // saves the value of the tab animation. For example, if one is between the 1st and the 2nd tab, this value will be 0.5
  double _aniValue = 0.0;

  // saves the previous value of the tab animation. It's used to figure the direction of the animation
  double _prevAniValue = 0.0;

  // active button's background color
  final Color _backgroundOn = PsColors.mainColor;
  final Color _backgroundOff = Colors.transparent;

  // scroll controller for the TabBar
  final ScrollController _scrollController = ScrollController();

  // this will save the keys for each Tab in the Tab Bar, so we can retrieve their position and size for the scroll controller
  final List<dynamic> _keys = <dynamic>[];
  final List<dynamic> _viewkeys = <dynamic>[];

  // regist if the the button was tapped
  bool _buttonTap = false;

  Map<int, bool> callFromDBIndexList = <int, bool>{};
  Map<int, Widget> widgetList = <int, Widget>{};

  @override
  void initState() {
    super.initState();

    // this creates the controller with 6 tabs (in our case)
    _controller =
        TabController(vsync: this, length: widget.categoryList.length);
    // this will execute the function every time there's a swipe animation
    _controller.animation.addListener(_handleTabAnimation);
    // this will execute the function every time the _controller.index value changes
    _controller.addListener(_handleTabChange);

    _animationControllerOff = AnimationController(
        vsync: this,
        duration:
            const Duration(microseconds: 140)); //PsConfig.animation_duration);
    // so the inactive buttons start in their "final" state (color)
    _animationControllerOff.value = 1.0;
    _colorTweenBackgroundOff =
        ColorTween(begin: _backgroundOn, end: _backgroundOff)
            .animate(_animationControllerOff);

    _animationControllerOn = AnimationController(
        vsync: this,
        duration:
            const Duration(microseconds: 140)); //PsConfig.animation_duration);
    // so the inactive buttons start in their "final" state (color)
    _animationControllerOn.value = 1.0;
    _colorTweenBackgroundOn =
        ColorTween(begin: _backgroundOff, end: _backgroundOn)
            .animate(_animationControllerOn);
  }

  @override
  void dispose() {
    _controller.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final ProductParameterHolder productParameterHolder =
        ProductParameterHolder().getLatestParameterHolder();
    productParameterHolder.shopId = widget.shopId;
    for (int index = 0; index < widget.categoryList.length; index++) {
      // create a GlobalKey for each Tab
      if (_keys != null && _keys.length <= index) {
        _keys.add(GlobalKey());
        _viewkeys.add(GlobalKey());
      }
    }

    final List<int> fixedList =
        Iterable<int>.generate(widget.categoryList.length).toList();
    return Scaffold(
      backgroundColor: PsColors.baseColor,
      body: Stack(
        alignment: Alignment.bottomLeft,
        children: <Widget>[
          Column(children: <Widget>[
            Row(
              children: <Widget>[
                const SizedBox(
                  width: PsDimens.space4,
                ),
                Flexible(
                    child: PsTextFieldWidgetWithIcon(
                  hintText:
                      Utils.getString(context, 'home__bottom_app_bar_search'),
                  textEditingController:
                      widget.userInputItemNameTextEditingController,
                  psValueHolder: widget.valueHolder,
                  textInputAction: TextInputAction.search,
                )),
                Container(
                  height: PsDimens.space44,
                  alignment: Alignment.center,
                  decoration: BoxDecoration(
                    color: PsColors.baseDarkColor,
                    borderRadius: BorderRadius.circular(PsDimens.space4),
                    border: Border.all(color: PsColors.mainDividerColor),
                  ),
                  child: InkWell(
                      child: Container(
                        height: double.infinity,
                        width: PsDimens.space44,
                        child: Icon(
                          Octicons.settings,
                          color: PsColors.mainColor,
                          size: PsDimens.space20,
                        ),
                      ),
                      onTap: () async {
                        productParameterHolder.searchTerm =
                            widget.userInputItemNameTextEditingController.text;
                        Utils.psPrint(productParameterHolder.searchTerm);
                        Navigator.pushNamed(
                            context, RoutePaths.dashboardsearchFood,
                            arguments: ProductListIntentHolder(
                                appBarTitle: Utils.getString(
                                    context, 'home_search__app_bar_title'),
                                productParameterHolder:
                                    productParameterHolder));
                      }),
                ),
                const SizedBox(
                  width: PsDimens.space16,
                ),
              ],
            ),
            // this is the TabBar
            Container(
              height: PsDimens.space48,
              // this generates our tabs buttons
              child: SingleChildScrollView(
                scrollDirection: Axis.horizontal,
                controller: _scrollController,
                child: Row(
                  children: <Widget>[
                    const SizedBox(
                      width: PsDimens.space20,
                    ),
                    Row(
                        children: fixedList.map((int index) {
                      return Padding(
                          // each button's key
                          key: _keys[index],
                          // padding for the buttons
                          padding:
                              // index == 0
                              //     ? const EdgeInsets.only(left: PsDimens.space20)
                              //     :
                              const EdgeInsets.only(left: PsDimens.space1),
                          child: ButtonTheme(
                              child: AnimatedBuilder(
                            animation: _colorTweenBackgroundOn,
                            builder: (BuildContext context, Widget child) =>
                                FlatButton(
                                    // get the color of the button's background (dependent of its state)
                                    color: _getBackgroundColor(index),
                                    // make the button a rectangle with round corners
                                    shape: RoundedRectangleBorder(
                                        borderRadius:
                                            BorderRadius.circular(7.0)),
                                    onPressed: () {
                                      setState(() {
                                        _buttonTap = true;
                                        // trigger the controller to change between Tab Views
                                        _controller.animateTo(index);
                                        // set the current index
                                        _setCurrentIndex(index);
                                        // scroll to the tapped button (needed if we tap the active button and it's not on its position)
                                        _scrollTo(index);
                                      });
                                    },
                                    child: Text(widget.categoryList[index].name,
                                        style: Theme.of(context)
                                            .textTheme
                                            .bodyText1
                                            .copyWith(
                                                color: _getTextColor(index)))),
                          )));
                    }).toList()),
                  ],
                ),
              ),
            ),
            const SizedBox(
              height: PsDimens.space8,
            ),
            Flexible(
                // this will host our Tab Views
                child: TabBarView(
              key: const Key('_1'),
              // and it is controlled by the controller
              controller: _controller,
              children: <Widget>[
                for (int i = 0; i < widget.categoryList.length; i++)
                  getWidget(i, _currentIndex)
              ],
            )),
          ]),
          Row(
            mainAxisAlignment: MainAxisAlignment.end,
            crossAxisAlignment: CrossAxisAlignment.end,
            children: <Widget>[
              Container(
                  margin: const EdgeInsets.only(
                      top: PsDimens.space12,
                      bottom: PsDimens.space12,
                      right: PsDimens.space12,
                      left: PsDimens.space12),
                  child: FloatingActionButton(
                    heroTag: '',
                    backgroundColor: PsColors.mainColor,
                    //mini: true,
                    child: Icon(
                      Feather.shopping_bag,
                      color: PsColors.white,
                    ),
                    onPressed: () async {
                      Navigator.pushNamed(
                          context, RoutePaths.shop_info_container,
                          arguments: widget.shopId);
                    },
                  )),
            ],
          ),
        ],
      ),
    );
  }

  // runs during the switching tabs animation
  dynamic _handleTabAnimation() {
    // gets the value of the animation. For example, if one is between the 1st and the 2nd tab, this value will be 0.5
    _aniValue = _controller.animation.value;

    // if the button wasn't pressed, which means the user is swiping, and the amount swipped is less than 1 (this means that we're swiping through neighbor Tab Views)
    if (!_buttonTap && ((_aniValue - _prevAniValue).abs() < 1)) {
      // set the current tab index
      _setCurrentIndex(_aniValue.round());
    }

    // save the previous Animation Value
    _prevAniValue = _aniValue;
  }

  // runs when the displayed tab changes
  dynamic _handleTabChange() {
    // if a button was tapped, change the current index
    if (_buttonTap) {
      _setCurrentIndex(_controller.index);
    }

    // this resets the button tap
    if ((_controller.index == _prevControllerIndex) ||
        (_controller.index == _aniValue.round())) {
      _buttonTap = false;
    }

    // save the previous controller index
    _prevControllerIndex = _controller.index;
  }

  dynamic _setCurrentIndex(int index) {
    // if we're actually changing the index
    if (index != _currentIndex) {
      setState(() {
        // change the index
        _currentIndex = index;
        callFromDBIndexList[_currentIndex] = true;
        // if (callFromDBIndexList.containsKey(index)) {
        //   callFromDBIndexList.update(index, (bool v) {
        //     return true;
        //   });
        // } else {
        //   callFromDBIndexList[index] = false;
        // }
      });

      // trigger the button animation
      _triggerAnimation();
      // scroll the TabBar to the correct position (if we have a scrollable bar)
      _scrollTo(index);
    }
  }

  dynamic _triggerAnimation() {
    // reset the animations so they're ready to go
    _animationControllerOn.reset();
    _animationControllerOff.reset();

    // run the animations!
    _animationControllerOn.forward();
    _animationControllerOff.forward();
  }

  dynamic _scrollTo(int index) {
    // get the screen width. This is used to check if we have an element off screen
    double screenWidth = MediaQuery.of(context).size.width;

    // get the button we want to scroll to
    RenderBox renderBox = _keys[index].currentContext.findRenderObject();
    // get its size
    double size = renderBox.size.width;
    // and position
    double position = renderBox.localToGlobal(Offset.zero).dx;

    // this is how much the button is away from the center of the screen and how much we must scroll to get it into place
    double offset = (position + size / 2) - screenWidth / 2;

    // if the button is to the left of the middle
    if (offset < 0) {
      // get the first button
      renderBox = _keys[0].currentContext.findRenderObject();
      // get the position of the first button of the TabBar
      position = renderBox.localToGlobal(Offset.zero).dx;

      // if the offset pulls the first button away from the left side, we limit that movement so the first button is stuck to the left side
      if (position > offset) {
        offset = position;
      }
    } else {
      // if the button is to the right of the middle

      // get the last button
      renderBox = _keys[widget.categoryList.length - 1]
          .currentContext
          .findRenderObject();
      // get its position
      position = renderBox.localToGlobal(Offset.zero).dx;
      // and size
      size = renderBox.size.width;

      // if the last button doesn't reach the right side, use it's right side as the limit of the screen for the TabBar
      if (position + size < screenWidth) {
        screenWidth = position + size;
      }

      // if the offset pulls the last button away from the right side limit, we reduce that movement so the last button is stuck to the right side limit
      if (position + size - offset < screenWidth) {
        offset = position + size - screenWidth;
      }
    }

    // scroll the calculated ammount
    _scrollController.animateTo(offset + _scrollController.offset,
        duration: const Duration(milliseconds: 1200), curve: Curves.easeInOut);
  }

  dynamic _getBackgroundColor(int index) {
    if (index == _currentIndex) {
      // if it's active button
      return _colorTweenBackgroundOn.value;
    } else if (index == _prevControllerIndex) {
      // if it's the previous active button
      return _colorTweenBackgroundOff.value;
    } else {
      // if the button is inactive
      return _backgroundOff;
    }
  }

  dynamic _getTextColor(int index) {
    if (index == _currentIndex) {
      // if it's active button
      return PsColors.white;
    }
  }

  Widget getWidget(int i, int currentIndex) {
    // If widget is inside cache, just return from cache.
    if (widgetList[i] != null) {
      return widgetList[i];
    }

    final int widgetIndex = i;
    // Prepare only 3 indexs
    // int widgetIndex = 0;
    // if (i == currentIndex - 1) {
    //   widgetIndex = i;
    // } else if (i == currentIndex + 1) {
    //   widgetIndex = i;
    // } else if (i == currentIndex) {
    //   widgetIndex = currentIndex;
    // } else {
    //   return Container();
    // }

    // Check Category Id
    final String _catId = widget.categoryList[widgetIndex].id;
    if (_catId == null || _catId == '') {
      return Container();
    }

    // Check Which UI Widget to return
    Utils.psPrint('index $widgetIndex');
    Utils.psPrint(_catId);

    if (_catId == PsConst.specialCollection) {
      // Collection View Widget
      widgetList[widgetIndex] =
          DashboardCollectionHeaderListView(shopId: widget.shopId);
      return widgetList[widgetIndex];
    } else if (_catId == PsConst.featuredItem) {
      // Featured Item List View Widget
      widgetList[widgetIndex] = ProductListView(
        shopId: widget.shopId,
        key: _viewkeys[widgetIndex],
        catId: widget.categoryList[widgetIndex].id,
        flag: callFromDBIndexList[widgetIndex] ?? false,
        isFeaturedItem: true,
      );

      return widgetList[widgetIndex];
    } else {
      // Normal Project List View Widget
      widgetList[widgetIndex] = ProductListView(
        shopId: widget.shopId,
        key: _viewkeys[widgetIndex],
        catId: widget.categoryList[widgetIndex].id,
        flag: callFromDBIndexList[widgetIndex] ?? false,
        isFeaturedItem: false,
      );

      return widgetList[widgetIndex];
    }
  }
}
