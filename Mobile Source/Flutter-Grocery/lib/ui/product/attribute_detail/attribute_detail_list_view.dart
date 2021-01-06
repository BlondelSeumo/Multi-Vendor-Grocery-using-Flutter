import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/config/ps_config.dart';
import 'package:fluttermultigrocery/ui/product/attribute_detail/attribute_detail_list_item_view.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/viewobject/customized_detail.dart';
import 'package:fluttermultigrocery/viewobject/product.dart';

class AttributeDetailListView extends StatefulWidget {
  const AttributeDetailListView(
      {Key key,
      @required this.customizedDetailList,
      this.product,
      this.onTap,
      this.animationController,
      this.animation})
      : super(key: key);

  final List<CustomizedDetail> customizedDetailList;
  final Product product;
  final Function onTap;
  final AnimationController animationController;
  final Animation<double> animation;
  @override
  State<StatefulWidget> createState() {
    return _AttributeDetailListViewState();
  }
}

class _AttributeDetailListViewState extends State<AttributeDetailListView>
    with TickerProviderStateMixin {
  final ScrollController _scrollController = ScrollController();

  AnimationController animationController;
  Animation<double> animation;

  @override
  void dispose() {
    animationController.dispose();
    animation = null;
    super.dispose();
  }

  @override
  void initState() {
    animationController =
        AnimationController(duration: PsConfig.animation_duration, vsync: this);
    animation = Tween<double>(
      begin: 0.0,
      end: 10.0,
    ).animate(animationController);
    super.initState();
  }

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

    print(
        '............................Build UI Again ............................');

    return WillPopScope(
      onWillPop: _requestPop,
      child: Scaffold(
        appBar: AppBar(
          brightness: Utils.getBrightnessForAppBar(context),
          iconTheme: Theme.of(context)
              .iconTheme
              .copyWith(color: PsColors.mainColorWithWhite),
          title: Text(
              Utils.getString(context, 'attribute_detail_list__app_bar_name'),
              textAlign: TextAlign.center,
              style: Theme.of(context)
                  .textTheme
                  .headline6
                  .copyWith(fontWeight: FontWeight.bold)
                  .copyWith(color: PsColors.mainColorWithWhite)),
          elevation: 0,
        ),
        body: Container(
          color: PsColors.coreBackgroundColor,
          child: ListView.builder(
              controller: _scrollController,
              itemCount: widget.customizedDetailList.length,
              itemBuilder: (BuildContext context, int index) {
                final int count = widget.customizedDetailList.length;
                return FadeTransition(
                    opacity: animation,
                    child: AttributeDetailListItem(
                      animationController: animationController,
                      animation: Tween<double>(begin: 0.0, end: 1.0).animate(
                        CurvedAnimation(
                          parent: animationController,
                          curve: Interval((1 / count) * index, 1.0,
                              curve: Curves.fastOutSlowIn),
                        ),
                      ),
                      attributeDetail: widget.customizedDetailList[index],
                      product: widget.product,
                      onTap: () {
                        Navigator.pop(
                            context, widget.customizedDetailList[index]);
                      },
                    ));
              }),
        ),
      ),
    );
  }
}
