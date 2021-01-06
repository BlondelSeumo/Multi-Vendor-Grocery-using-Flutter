import 'package:fluttermultigrocery/api/common/ps_status.dart';
import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/config/ps_config.dart';
import 'package:fluttermultigrocery/provider/shipping_area/shipping_area_provider.dart';
import 'package:fluttermultigrocery/repository/shipping_area_repository.dart';
import 'package:fluttermultigrocery/ui/common/base/ps_widget_with_appbar.dart';
import 'package:fluttermultigrocery/ui/common/ps_frame_loading_widget.dart';
import 'package:fluttermultigrocery/ui/common/ps_ui_widget.dart';
import 'package:fluttermultigrocery/ui/user/edit_profile/area_list_item.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_value_holder.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:shimmer/shimmer.dart';

class AreaListView extends StatefulWidget {
  @override
  State<StatefulWidget> createState() {
    return _AreaListViewState();
  }
}

class _AreaListViewState extends State<AreaListView>
    with TickerProviderStateMixin {
  final ScrollController _scrollController = ScrollController();

  ShippingAreaProvider shippingAreaProvider;
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
    _scrollController.addListener(() {
      if (_scrollController.position.pixels ==
          _scrollController.position.maxScrollExtent) {
        shippingAreaProvider.nextShippingAreaList(psValueHolder.shopId);
      }
    });

    animationController =
        AnimationController(duration: PsConfig.animation_duration, vsync: this);
    animation = Tween<double>(
      begin: 0.0,
      end: 10.0,
    ).animate(animationController);
    super.initState();
  }

  ShippingAreaRepository repo1;
  PsValueHolder psValueHolder;

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

    repo1 = Provider.of<ShippingAreaRepository>(context);
    psValueHolder = Provider.of<PsValueHolder>(context);

    print(
        '............................Build UI Again ............................');

    return WillPopScope(
        onWillPop: _requestPop,
        child: PsWidgetWithAppBar<ShippingAreaProvider>(
            appBarTitle:
                Utils.getString(context, 'area_list__app_bar_name') ?? '',
            initProvider: () {
              return ShippingAreaProvider(
                  repo: repo1, psValueHolder: psValueHolder);
            },
            onProviderReady: (ShippingAreaProvider provider) {
              provider.loadShippingAreaList(psValueHolder.shopId);
              shippingAreaProvider = provider;
              return shippingAreaProvider;
            },
            builder: (BuildContext context, ShippingAreaProvider provider,
                Widget child) {
              return Stack(children: <Widget>[
                Container(
                    child: RefreshIndicator(
                  child: ListView.builder(
                      controller: _scrollController,
                      physics: const AlwaysScrollableScrollPhysics(),
                      itemCount: provider.shippingAreaList.data.length,
                      itemBuilder: (BuildContext context, int index) {
                        if (provider.shippingAreaList.status ==
                            PsStatus.BLOCK_LOADING) {
                          return Shimmer.fromColors(
                              baseColor: PsColors.grey,
                              highlightColor: PsColors.white,
                              child: Column(children: const <Widget>[
                                PsFrameUIForLoading(),
                                PsFrameUIForLoading(),
                                PsFrameUIForLoading(),
                                PsFrameUIForLoading(),
                                PsFrameUIForLoading(),
                                PsFrameUIForLoading(),
                                PsFrameUIForLoading(),
                                PsFrameUIForLoading(),
                                PsFrameUIForLoading(),
                                PsFrameUIForLoading(),
                              ]));
                        } else {
                          final int count =
                              provider.shippingAreaList.data.length;
                          return FadeTransition(
                              opacity: animation,
                              child: AreaListItem(
                                animationController: animationController,
                                animation:
                                    Tween<double>(begin: 0.0, end: 1.0).animate(
                                  CurvedAnimation(
                                    parent: animationController,
                                    curve: Interval((1 / count) * index, 1.0,
                                        curve: Curves.fastOutSlowIn),
                                  ),
                                ),
                                area: provider.shippingAreaList.data[index],
                                onTap: () {
                                  Navigator.pop(context,
                                      provider.shippingAreaList.data[index]);
                                },
                              ));
                        }
                      }),
                  onRefresh: () {
                    return provider.resetShippingAreaList(psValueHolder.shopId);
                  },
                )),
                PSProgressIndicator(provider.shippingAreaList.status)
              ]);
            }));
  }
}
