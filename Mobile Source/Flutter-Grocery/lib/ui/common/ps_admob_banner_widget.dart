import 'dart:async';
import 'package:flutter/material.dart';
import 'package:flutter_native_admob/flutter_native_admob.dart';
import 'package:flutter_native_admob/native_admob_controller.dart';
import 'package:flutter_native_admob/native_admob_options.dart';
import 'package:fluttermultigrocery/config/ps_config.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/utils/utils.dart';

class PsAdMobBannerWidget extends StatefulWidget {
  const PsAdMobBannerWidget({this.admobSize = NativeAdmobType.banner});

  //final AdmobBannerSize admobBannerSize;
  final NativeAdmobType admobSize;

  @override
  _PsAdMobBannerWidgetState createState() => _PsAdMobBannerWidgetState();
}

class _PsAdMobBannerWidgetState extends State<PsAdMobBannerWidget> {
  bool isShouldLoadAdMobBanner = true;
  bool isConnectedToInternet = false;
  int currentRetry = 0;
  int retryLimit = 1;

  // ignore: always_specify_types
  StreamSubscription _subscription;
  final NativeAdmobController _controller = NativeAdmobController();
  double _height = 0;

  @override
  void initState() {
    _subscription = _controller.stateChanged.listen(_onStateChanged);
    super.initState();
  }

  @override
  void dispose() {
    _subscription.cancel();
    super.dispose();
  }

  void checkConnection() {
    Utils.checkInternetConnectivity().then((bool onValue) {
      isConnectedToInternet = onValue;
      if (isConnectedToInternet && PsConfig.showAdMob) {
        setState(() {});
      }
    });
  }

  void _onStateChanged(AdLoadState state) {
    switch (state) {
      case AdLoadState.loading:
        setState(() {
          _height = 0;
        });
        break;

      case AdLoadState.loadCompleted:
        setState(() {
          if (widget.admobSize == NativeAdmobType.banner) {
            _height = 80;
          } else {
            _height = 330;
          }
        });
        break;

      default:
        break;
    }
  }

  @override
  Widget build(BuildContext context) {
    return Container(
        height: _height,
        padding: const EdgeInsets.all(PsDimens.space16),
        child: NativeAdmob(
          adUnitID: Utils.getBannerAdUnitId(),
          loading: Container(),
          error: Container(),
          controller: _controller,
          type: widget.admobSize,
          options: const NativeAdmobOptions(
            ratingColor: Colors.red,
          ),
        ));
  }
}
