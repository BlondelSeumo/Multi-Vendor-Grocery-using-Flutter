import 'package:fluttermultigrocery/viewobject/transaction_status.dart';
import 'package:sembast/sembast.dart';
import 'package:fluttermultigrocery/db/common/ps_dao.dart' show PsDao;

class TransactionStatusDao extends PsDao<TransactionStatus> {
  TransactionStatusDao._() {
    init(TransactionStatus());
  }
  static const String STORE_NAME = 'TransactionStatus';
  final String _primaryKey = 'id';

  // Singleton instance
  static final TransactionStatusDao _singleton = TransactionStatusDao._();

  // Singleton accessor
  static TransactionStatusDao get instance => _singleton;

  @override
  String getStoreName() {
    return STORE_NAME;
  }

  @override
  String getPrimaryKey(TransactionStatus object) {
    return object.id;
  }

  @override
  Filter getFilter(TransactionStatus object) {
    return Filter.equals(_primaryKey, object.id);
  }
}
