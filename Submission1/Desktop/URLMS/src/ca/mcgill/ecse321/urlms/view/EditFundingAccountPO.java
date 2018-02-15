package ca.mcgill.ecse321.urlms.view;

import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.border.EmptyBorder;

import ca.mcgill.ecse321.urlms.controller.FundingController;
import ca.mcgill.ecse321.urlms.controller.InvalidInputException;

import javax.swing.GroupLayout;
import javax.swing.GroupLayout.Alignment;
import javax.swing.JTextField;
import javax.swing.LayoutStyle.ComponentPlacement;
import javax.swing.JButton;
import java.awt.event.ActionListener;
import java.awt.event.ActionEvent;
import javax.swing.JLabel;
import javax.swing.JScrollPane;

public class EditFundingAccountPO extends JFrame {

	private JPanel contentPane;
	public static FundingController controller = new FundingController();
	private JTextField txtOldAccountType;
	private JTextField txtNewAccountType;
	private String error;
	private JButton btnClose;
	private JScrollPane scrollPane;
	private JLabel lblError;

	/**
	 * Create the frame.
	 */
	public EditFundingAccountPO() {
		setResizable(false);
		setAlwaysOnTop(true);
		initComponents();
	}
	
	private void initComponents(){
		setTitle("Edit Funding Account");
		setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
		setBounds(100, 100, 568, 320);
		contentPane = new JPanel();
		contentPane.setBorder(new EmptyBorder(5, 5, 5, 5));
		setContentPane(contentPane);
		
		txtOldAccountType = new JTextField();
		txtOldAccountType.setColumns(10);
		
		txtNewAccountType = new JTextField();
		txtNewAccountType.setColumns(10);
		
		JButton btnEdit = new JButton("Edit");
		btnEdit.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				error = "";
				try {
					String oldAccountType = txtOldAccountType.getText();
					String newAccountType = txtNewAccountType.getText();
					controller.editFundingAccount(oldAccountType, newAccountType);
				} catch (InvalidInputException e1) {
					error += e1.getMessage();
				} catch (RuntimeException e1) {
					error += "stuff happened. ";
				}
				refreshData();
			}
		});
		
		JLabel lblOldAccountType = new JLabel("Old Account Type (Case sensitive):");
		
		JLabel lblNewAccountType = new JLabel("New Account Type:");
		
		btnClose = new JButton("Close");
		btnClose.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				close();
			}
		});
		
		scrollPane = new JScrollPane();
		GroupLayout gl_contentPane = new GroupLayout(contentPane);
		gl_contentPane.setHorizontalGroup(
			gl_contentPane.createParallelGroup(Alignment.TRAILING)
				.addGroup(gl_contentPane.createSequentialGroup()
					.addContainerGap(29, Short.MAX_VALUE)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.LEADING)
						.addGroup(gl_contentPane.createSequentialGroup()
							.addGroup(gl_contentPane.createParallelGroup(Alignment.TRAILING)
								.addComponent(lblNewAccountType)
								.addComponent(lblOldAccountType))
							.addGap(18)
							.addGroup(gl_contentPane.createParallelGroup(Alignment.LEADING, false)
								.addComponent(txtNewAccountType)
								.addComponent(txtOldAccountType, GroupLayout.PREFERRED_SIZE, 239, GroupLayout.PREFERRED_SIZE))
							.addGap(18))
						.addGroup(Alignment.TRAILING, gl_contentPane.createSequentialGroup()
							.addComponent(btnEdit)
							.addPreferredGap(ComponentPlacement.RELATED)
							.addComponent(btnClose)
							.addGap(201))))
				.addGroup(gl_contentPane.createSequentialGroup()
					.addGap(27)
					.addComponent(scrollPane)
					.addGap(17))
		);
		gl_contentPane.setVerticalGroup(
			gl_contentPane.createParallelGroup(Alignment.LEADING)
				.addGroup(gl_contentPane.createSequentialGroup()
					.addGap(36)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(txtOldAccountType, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
						.addComponent(lblOldAccountType))
					.addPreferredGap(ComponentPlacement.UNRELATED)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(txtNewAccountType, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
						.addComponent(lblNewAccountType))
					.addGap(16)
					.addComponent(scrollPane, GroupLayout.PREFERRED_SIZE, 50, GroupLayout.PREFERRED_SIZE)
					.addGap(21)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(btnEdit)
						.addComponent(btnClose))
					.addContainerGap(50, Short.MAX_VALUE))
		);
		
		lblError = new JLabel("You can edit accounts here.");
		scrollPane.setViewportView(lblError);
		contentPane.setLayout(gl_contentPane);
	}
	
	private void refreshData(){
		if(error.length() > 0){
			lblError.setText(error);
		}
		else{
			lblError.setText("Account successfully edited.");
		}
	}
	
	public void close() { 
		this.setVisible(false);
	    this.dispose();
	}
}
