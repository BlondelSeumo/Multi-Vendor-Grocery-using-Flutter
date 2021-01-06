import 'dart:async';
import 'package:fluttermultigrocery/repository/transaction_status_repository.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/api/common/ps_resource.dart';
import 'package:fluttermultigrocery/api/common/ps_status.dart';
import 'package:fluttermultigrocery/provider/common/ps_provider.dart';
import 'package:fluttermultigrocery/viewobject/transaction_status.dart';

class TransactionStatusProvider extends PsProvider {
  TransactionStatusProvider(
      {@required TransactionStatusRepository repo, int limit = 0})
      : super(repo, limit) {
    _repo = repo;

    print('TransactionStatus Provider: $hashCode');

    Utils.checkInternetConnectivity().then((bool onValue) {
      isConnectedToInternet = onValue;
    });
    transactionStatusListStream =
        StreamController<PsResource<List<TransactionStatus>>>.broadcast();
    subscription = transactionStatusListStream.stream
        .listen((PsResource<List<TransactionStatus>> resource) {
      updateOffset(resource.data.length);

      _transactionStatusList = resource;

      if (resource.status != PsStatus.BLOCK_LOADING &&
          resource.status != PsStatus.PROGRESS_LOADING) {
        isLoading = false;
      }

      if (!isDispose) {
        notifyListeners();
      }
    });
  }

  TransactionStatusRepository _repo;

  PsResource<List<TransactionStatus>> _transactionStatusList =
      PsResource<List<TransactionStatus>>(
          PsStatus.NOACTION, '', <TransactionStatus>[]);

  PsResource<List<TransactionStatus>> get transactionStatusList =>
      _transactionStatusList;
  StreamSubscription<PsResource<List<TransactionStatus>>> subscription;
  StreamController<PsResource<List<TransactionStatus>>>
      transactionStatusListStream;
  @override
  void dispose() {
    subscription.cancel();
    transactionStatusListStream.close();
    isDispose = true;
    print('TransactionStatus Provider Dispose: $hashCode');
    super.dispose();
  }

  Future<dynamic> loadTransactionStatusList() async {
    isLoading = true;

    isConnectedToInternet = await Utils.checkInternetConnectivity();
    await _repo.getAllTransactionStatusList(transactionStatusListStream,
        isConnectedToInternet, PsStatus.PROGRESS_LOADING);
  }

  Future<dynamic> nextTransactionStatusList() async {
    isConnectedToInternet = await Utils.checkInternetConnectivity();

    if (!isLoading && !isReachMaxData) {
      super.isLoading = true;
      await _repo.getNextPageTransactionStatusList(transactionStatusListStream,
          isConnectedToInternet, PsStatus.PROGRESS_LOADING);
    }
  }

  Future<void> resetTransactionStatusList() async {
    isConnectedToInternet = await Utils.checkInternetConnectivity();
    isLoading = true;

    updateOffset(0);

    await _repo.getAllTransactionStatusList(transactionStatusListStream,
        isConnectedToInternet, PsStatus.PROGRESS_LOADING);

    isLoading = false;
  }
}
