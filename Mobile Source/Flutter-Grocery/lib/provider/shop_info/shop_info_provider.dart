import 'dart:async';
import 'package:fluttermultigrocery/repository/shop_info_repository.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_value_holder.dart';
import 'package:fluttermultigrocery/viewobject/shop_info.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/api/common/ps_resource.dart';
import 'package:fluttermultigrocery/api/common/ps_status.dart';
import 'package:fluttermultigrocery/provider/common/ps_provider.dart';

class ShopInfoProvider extends PsProvider {
  ShopInfoProvider(
      {@required ShopInfoRepository repo,
      @required this.psValueHolder,
      @required this.ownerCode,
      int limit = 0})
      : super(repo, limit) {
    _repo = repo;

    print('ShopInfo Provider: $hashCode ($ownerCode) ');

    Utils.checkInternetConnectivity().then((bool onValue) {
      isConnectedToInternet = onValue;
    });

    shopInfoListStream = StreamController<PsResource<ShopInfo>>.broadcast();
    subscription =
        shopInfoListStream.stream.listen((PsResource<ShopInfo> resource) {
      _shopInfo = resource;

      if (resource.status != PsStatus.BLOCK_LOADING &&
          resource.status != PsStatus.PROGRESS_LOADING) {
        isLoading = false;
      }

      if (!isDispose) {
        // Update to share preference
        // To submit tax and shipping tax to transaction

        if (_shopInfo != null && shopInfo.data != null) {
          replaceShopInfoValueHolderData(
            _shopInfo.data.overallTaxLabel,
            _shopInfo.data.overallTaxValue,
            _shopInfo.data.shippingTaxLabel,
            _shopInfo.data.shippingTaxValue,
            _shopInfo.data.shippingId,
            _shopInfo.data.id,
            _shopInfo.data.messenger,
            _shopInfo.data.whapsappNo,
            _shopInfo.data.aboutPhone1,
            _shopInfo.data.minimumOrderAmount,
          );

          replaceCheckoutEnable(
              _shopInfo.data.paypalEnabled,
              _shopInfo.data.stripeEnabled,
              _shopInfo.data.paystackEnabled,
              _shopInfo.data.codEmail,
              _shopInfo.data.banktransferEnabled,
              _shopInfo.data.standardShippingEnable,
              _shopInfo.data.zoneShippingEnable,
              _shopInfo.data.noShippingEnable);
          replacePublishKey(_shopInfo.data.stripePublishableKey);
          replacePayStackKey(_shopInfo.data.paystackKey);

          notifyListeners();
        }
      }
    });
  }

  ShopInfoRepository _repo;
  PsValueHolder psValueHolder;
  String ownerCode;
  ShopInfo selectedShop;

  PsResource<ShopInfo> _shopInfo =
      PsResource<ShopInfo>(PsStatus.NOACTION, '', null);

  PsResource<ShopInfo> get shopInfo => _shopInfo;
  StreamSubscription<PsResource<ShopInfo>> subscription;
  StreamController<PsResource<ShopInfo>> shopInfoListStream;
  @override
  void dispose() {
    subscription.cancel();
    shopInfoListStream.close();
    isDispose = true;
    print('ShopInfo Provider Dispose: $hashCode');
    super.dispose();
  }

  Future<dynamic> loadShopInfo(String shopId) async {
    isLoading = true;
    isConnectedToInternet = await Utils.checkInternetConnectivity();

    await _repo.getShopInfo(shopInfoListStream, shopId, isConnectedToInternet,
        PsStatus.PROGRESS_LOADING);
  }

  Future<dynamic> nextShopInfoList(String shopId) async {
    if (!isLoading && !isReachMaxData) {
      super.isLoading = true;
      isConnectedToInternet = await Utils.checkInternetConnectivity();
      await _repo.getShopInfo(shopInfoListStream, shopId, isConnectedToInternet,
          PsStatus.PROGRESS_LOADING);
    }
  }

  Future<void> resetShopInfoList(String shopId) async {
    isLoading = true;
    isConnectedToInternet = await Utils.checkInternetConnectivity();
    await _repo.getShopInfo(shopInfoListStream, shopId, isConnectedToInternet,
        PsStatus.BLOCK_LOADING);

    isLoading = false;
  }
}
